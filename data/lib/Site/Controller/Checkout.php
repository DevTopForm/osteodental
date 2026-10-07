<?php

namespace App\Site\Controller;

use App\Cabinet\LoginManager;
use App\Cabinet\User;
use App\Item\Catalog;
use App\Item\Order;
use App\Item\Order\Payment;
use App\Item\Order\Status;
use App\Message;
use App\Query;
use App\Registry;
use App\Site\Controller;
use App\Site\Basket as SiteBasket;
use App\Template;
use App\Utils;
use PHPMailer\PHPMailer\PHPMailer;

class Checkout extends Controller
{
    private static string|null $status = null;

    public function isDispatchable($pathStr): false|int
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match('/^checkout\/.*$/', $pathStr);
    }

    public function run(): void
    {
        $success = false;
        $data = [];

        $item = new Catalog((int)Query::$request['product_id']);

        switch ($this->path[1]) {
            case 'add':
                if (empty($item->id) || empty(Query::$post['variation_id'])) {
                    break;
                }

                $variant = $item->getVariant(Query::$post['variation_id']);

                if (!empty($variant["id"])) {
                    $count = (int)Query::$get['count'] ?: 1;

                    if (SiteBasket::getInstance()->isAdded($item, $variant)) {
                        $data = ["message" => "Товар с такими параметрами уже добавлен!"];
                    } else {
                        SiteBasket::getInstance()->addItem($item, $count, $variant);
                        $success = true;
                        $data = ["cart_count" => SiteBasket::getInstance()->getTotal()["count"]];
                    }
                }

                break;

            case 'count':
                if (empty($item->id)) {
                    break;
                }

                if (isset(Query::$get['variant'])) {
                    $key = ((int)Query::$get['item']) . '-' . ((int)Query::$get['variant']);
                } else {
                    $key = (int)Query::$get['item'];
                }
                SiteBasket::getInstance()->setCount($key, (int)Query::$get['count']);
                $success = true;
                break;

            case 'remove':
                if (empty($item->id) || empty(Query::$get['variation_id'])) {
                    break;
                }

                $variant = $item->getVariant(Query::$get['variation_id']);

                if (!empty($variant["id"])) {
                    $basket = SiteBasket::getInstance();
                    $key = $basket->getKeyForArray($item, $variant);
                    $basket->removeItem($key);
                    Utils::redirectPrevious();
                }

                break;
        }

        $result = [
            'success' => $success,
            'data' => $data,
        ];
        echo json_encode($result);
        die;
    }

    protected static function processCheckout()
    {
        if (empty(Query::$post)) {
            return [];
        }

        $errors = [];

        if (Query::$post['action'] == 'saveorder') {
            if (empty(Query::$post['agreed'])) {
                $errors[] = new Message(
                    'Подтвердите согласие с Политикой конфиденциальности', 'error'
                );
            }
            try {
                $user = LoginManager::getLoggedUser();
            } catch (\Exception $e) {
                $user = null;
            }

            $order = new Order();
            $order->data = SiteBasket::getInstance()->getItems();
            $order->user = $user ?? 0;
            $order->firstname = strip_tags(Query::$post['name'] ?? '');
            $order->email = strip_tags(Query::$post['email'] ?? '');
            $order->phone = strip_tags(Query::$post['phone'] ?? '');
            $order->instagram = strip_tags(Query::$post['instagram'] ?? '');
            $currentPayment = Payment::getCurrent(Query::$post['payment'] ?? '');
            $order->payment_method = $currentPayment;
            $order->deliverySumm = 0;
            $order->status = new Status(1);
            $order->date = date('Y-m-d H:i:s', time());

            if (!empty($user->id)) {
                $order->firstname = $user->getName();
                $order->email = $order->email ?: $user->email;
                $order->phone = $order->phone ?: $user->phone ?? '';
            }

            $promocode = SiteBasket::getInstance()->getActivePromo();
            if (!empty($promocode->id)) {
                $order->promocode = $promocode->title . " (" . $promocode->code . ")";
            }

            $prices = SiteBasket::getInstance()->getPrices();
            $order->orderSumm = $prices["orderPrice"];
            $order->saleSumm = $prices["discountAmount"];
            $order->totalSumm = $prices["totalPrice"] + $order->deliverySumm;

            if (empty($user->id) && !empty($order->email)) {
                // Check if a user with this email already exists
                $existingUser = User::getByEmail($order->email);

                if (!empty($existingUser->id)) {
                    // Email already exists, prompt user to log in
                    $errors[] = new Message(
                        'Пользователь с таким email уже существует. Пожалуйста, <a href="/cabinet">авторизуйтесь</a> и продолжите оформление заказа.'
                    );

                    return $errors;
                }
            }

            if ($order->validate()) {
                // Create a new user account if user is not logged in and email is provided
                if (empty($user->id) && !empty($order->email)) {
                    // Generate a random password
                    $password = User::genPass();

                    // Create a new user
                    $newUser = new User();
                    $newUser->isOrderCreated = true;
                    $newUser->firstname = $order->firstname;
                    $newUser->lastname = '';
                    $newUser->email = $order->email;
                    $newUser->login = $order->email;
                    $newUser->phone = $order->phone;
                    $newUser->instagramm_login = $order->instagram;
                    $newUser->new_pass = $password;
                    $newUser->new_pass_2 = $password;
                    $newUser->hash = User::genHash($newUser->new_pass);
                    $newUser->active = 1;
                    $newUser->regdate = date('Y-m-d H:i:s');
                    $newUser->lastlogin = date('Y-m-d H:i:s');

                    // Save the user
                    if ($newUser->validate()) {
                        $newUser->save();

                        // Associate the order with the new user
                        $order->user = $newUser;

                        // Send email with login credentials
                        $tpl = new Template();
                        $tpl->assign('subject', "Регистрация на сайте");
                        $tpl->assign('user', $newUser);
                        $tpl->assign('password', $password);
                        $content = $tpl->fetch('mail/user-registration.tpl');

                        $mail = new PHPMailer();
                        $settings = Registry::get('settings');
                        $from = $settings->getSiteParams('from_email');
                        $site = $settings->getSiteParams('sitename');
                        $mail->From = empty($from) ? ("noreply@" . $_SERVER['SERVER_NAME']) : $from;
                        $mail->FromName = iconv('UTF-8', 'WINDOWS-1251', $site);
                        $mail->Subject = iconv('UTF-8', 'WINDOWS-1251', "Регистрация на сайте");
                        $mail->CharSet = 'Windows-1251';
                        $mail->SingleTo = true;
                        $mail->ContentType = 'text/html';
                        $mail->IsHTML(true);
                        $mail->AddAddress($newUser->email, iconv('UTF-8', 'WINDOWS-1251', $newUser->firstname));
                        $mail->MsgHTML(iconv('UTF-8', 'WINDOWS-1251', $content));
                        if (!$mail->Send()) {
                            pre($mail);
                        }
                    }
                }

                if ($order->validate()) {
                    $order->save();
                    $order->notify('make');
                    if (!empty($promocode->id) && $promocode->type == 1) {
                        $promocode->active = 0;

                        if ($promocode->validate()) {
                            $promocode->save();
                        }

                        unset($_SESSION['promocode']);
                    }

                    $_SESSION['lastorder'] = $order;
                    unset($_SESSION['basket']);

                    $link = $currentPayment->getPaymentLink($order);
                    if ($link) {
                        Utils::redirect($link);
                    } else {
                        static::$status = "success";
                    }
                }
            } else {
                $errors = $order->errors;
            }
        }

        return $errors;
    }

    public static function fetchTemplate(): string
    {
        $tpl = new Template();

        $items = SiteBasket::getInstance()->getItems();
        $payments = Payment::getList();
        $errors = static::processCheckout();

        $tpl->assign('content', $items);
        $tpl->assign('payments', $payments);
        $tpl->assign('errors', $errors);
        $tpl->assign('status', static::$status ?? "");
        try {
            $tpl->assign('user', LoginManager::getLoggedUser());
        } catch (\Exception $e) {
        }

        return $tpl->fetch('module/basket/checkout.tpl');
    }
}
