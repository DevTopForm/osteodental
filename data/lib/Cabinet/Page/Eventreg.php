<?php

namespace App\Cabinet\Page;

use App\Cabinet\LoginManager;
use App\Cabinet\Page;
use App\Cabinet\User;
use App\Item\Order;
use App\Item\Order\Status;
use App\Message;
use App\Query;
use App\Template;
use App\Utils;
use PHPMailer\PHPMailer\PHPMailer;
use Smarty\Exception;

class Eventreg extends Page
{
    protected string $localTpl = 'cabinet/registration-event.tpl';

    private array $errors = [];

    public User $user;
    public string $state;
    public Order $order;

    const STATE_REGISTER = 'register';
    const STATE_SUCCESS = 'success';
    const STATE_CONFIRM = 'confirm';
    const STATE_PRESAVED = 'presaved';

    protected function defineState(): void
    {
        if (empty($this->relativePath)) {
            $this->state = self::STATE_REGISTER;
            return;
        }
        foreach ($this->getStateRegexps() as $state => $regexp) {
            if (preg_match($regexp, $this->relativePath)) {
                $this->state = $state;
                return;
            }
        }
        $this->state = self::STATE_ERROR;
    }

    protected function getStateRegexps(): array
    {
        return [
            self::STATE_REGISTER => '/^[0-9]*$/i',
            self::STATE_SUCCESS => '/^success$/i',
            self::STATE_PRESAVED => '/^presaved$/i',
            self::STATE_CONFIRM => '/^confirm$/i',
        ];
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    protected function executeRequestProcessing(): void
    {
        try {
            $this->user = LoginManager::getLoggedUser();
            $this->tpl->assign('user', $this->user);
            $this->tpl->assign('eventreg', 1);
        } catch (\Exception) {
        }
        if ($this->state == self::STATE_REGISTER) {
            $this->registerUser();
        }
        if ($this->state == self::STATE_CONFIRM) {
            $this->confirmUser();
        }
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    protected function registerUser(): void
    {
        if (empty(Query::$post)) {
            return;
        }
        $this->order = new Order;
        $this->order->date = time();
        $this->order->from = Query::$post['from'];
        $this->order->from_comment = Query::$post['from_comment'];
        $this->order->status = new Status(2);

        if (empty($this->user)) {
            $this->user = new User;
            $this->user->active = 0;
            $this->user->new_pass = Query::$post['pass'];
            $this->user->new_pass_2 = Query::$post['pass_2'];
            $this->user->regdate = date("Y-m-d H:i");
            $this->user->firstname = @strip_tags(Query::$post['firstname']);
            $this->user->lastname = @strip_tags(Query::$post['lastname']);
            $this->user->middlename = @strip_tags(Query::$post['middlename']);
            $this->user->email = @strip_tags(Query::$post['email']);
            $this->user->login = $this->user->email;
            $this->user->phone = @strip_tags(Query::$post['phone']);
        } else {
            $this->user->firstname = @strip_tags(Query::$post['firstname']);
            $this->user->lastname = @strip_tags(Query::$post['lastname']);
            $this->user->middlename = @strip_tags(Query::$post['middlename']);
            if (empty($this->user->email)) {
                $this->user->email = @strip_tags(Query::$post['email']);
            }
            if (empty($this->user->phone)) {
                $this->user->phone = @strip_tags(Query::$post['phone']);
            }
        }
        switch ($this->order->payway) {
            case 'cash':
                $this->user->card = @strip_tags(Query::$post['card']);
                break;
            case 'beznal_fiz':
                $this->user->passport_serie = @strip_tags(Query::$post['passport_serie']);
                $this->user->passport_num = @strip_tags(Query::$post['passport_num']);
                $this->user->passport_when = empty(Query::$post['passport_when']) ? null : date(
                    'Y-m-d',
                    strtotime(Query::$post['passport_when'])
                );
                $this->user->passport_where = @strip_tags(Query::$post['passport_where']);
                $this->user->passport_address = @strip_tags(Query::$post['passport_address']);
                $this->user->card = @strip_tags(Query::$post['card']);
                break;
            case 'beznal_law':
                $this->user->company = @strip_tags(Query::$post['company']);
                $this->user->productgetter = @strip_tags(Query::$post['productgetter']);
                $this->user->inn = empty(Query::$post['inn']) ? '' : (int)Query::$post['inn'];
                $this->user->kpp = empty(Query::$post['kpp']) ? '' : (int)Query::$post['kpp'];
                $this->user->law_address = @strip_tags(Query::$post['law_address']);
                $this->user->fact_address = @strip_tags(Query::$post['fact_address']);
                $this->user->bik = empty(Query::$post['bik']) ? '' : (int)Query::$post['bik'];
                $this->user->ks = empty(Query::$post['ks']) ? '' : (int)Query::$post['ks'];
                $this->user->rs = empty(Query::$post['rs']) ? '' : (int)Query::$post['rs'];
                $this->user->bank = @strip_tags(Query::$post['bank']);
                $this->user->card = @strip_tags(Query::$post['card']);
                break;
            case 'abonement':
                $this->order->abonement_num = @strip_tags(Query::$post['abonement_num']);
                $this->order->paynum = $this->order->abonement_num;
                break;
            case 'invite':
                $this->order->invite_num = @strip_tags(Query::$post['invite_num']);
                $this->order->paynum = $this->order->invite_num;
                break;
            case 'promo':
                $this->order->promo_num = @strip_tags(Query::$post['promo_num']);
                $this->order->paynum = $this->order->promo_num;
                $this->order->status = new Status(2);
                break;
        }

        if (!empty(Query::$post['captcha'])) {
            if (Query::$post['captcha'] == $_SESSION['captcha_regevent']) {
                unset($_SESSION['captcha_regevent']);
            } else {
                $this->order->errors[] = new Message('Неверно заполнен проверочный код', 'error');
            }
        } else {
            $this->order->errors[] = new Message('Не заполнен проверочный код', 'error');
        }
        $this->order->user = $this->user;
        if ($this->order->validate() && empty($this->order->errors)) {
            if ($this->user->validate()) {
                if (empty($this->user->id)) {
                    $this->user->code = $this->generateConfirmation($this->user);
                    $this->user->save();
                    $_SESSION['tmp-order'] = $this->order;
                    $this->notifyNewUser();
                    Utils::redirect($this->pathPrefix . '/' . self::STATE_PRESAVED);
                } else {
                    $this->user->save();
                    $this->order->save();
                    $this->order->notify('make');
                    Utils::redirect($this->pathPrefix . '/' . self::STATE_SUCCESS);
                }
            } else {
                $this->errors = $this->user->errors;
            }
        } else {
            $this->errors = $this->order->errors;
        }
    }

    protected function confirmUser(): void
    {
        if (empty(Query::$get['token'])) {
            return;
        }
        $activated = User::activate(Query::$get['token']);

        if ($activated) {
            $order = $_SESSION['tmp-order'];
            if (!empty($order)) {
                try {
                    $this->user = LoginManager::getLoggedUser();
                    $order->user = $this->user;
                    if ($order->validate()) {
                        $order->save();
                        $order->notify('make');
                        Utils::redirect($this->pathPrefix . '/' . self::STATE_SUCCESS);
                    }
                } catch (\Exception) {
                }
            }
            Utils::redirect(SYS_CABINET_PATH_PREFIX);
        }
        $this->errors[] = new Message('Указан неверный код подтверждения', 'error');
    }

    protected function parseContent()
    {
        $method = sprintf('parseState%s', ucfirst($this->state));
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return sprintf('Пока не определено отображение для состояния: %s. Метод: %s', $this->state, $method);
    }

    protected function getTpl(): Template
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('state', $this->state);
        return $tpl;
    }

    /**
     * @throws Exception
     */
    protected function parseStateRegister(): string
    {
        $tpl = $this->getTpl();
        $tpl->assign('user', $this->user);
        $tpl->assign('order', $this->order);
        $tpl->assign('errors', $this->errors);
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws Exception
     */
    protected function parseStateSuccess(): string
    {
        $tpl = $this->getTpl();
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws Exception
     */
    protected function parseStatePresaved(): string
    {
        $tpl = $this->getTpl();
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws Exception
     */
    protected function parseStateConfirm(): string
    {
        $tpl = $this->getTpl();
        $tpl->assign('errors', $this->errors);
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    private function notifyUser(): void
    {
        $mail = new PHPMailer();
        $mail->From = "noreply@" . $_SERVER['SERVER_NAME'];
        $mail->FromName = iconv('UTF-8', 'WINDOWS-1251', "noreply@" . $_SERVER['SERVER_NAME']);
        $mail->Subject = iconv('UTF-8', 'WINDOWS-1251', "Регистрация на мероприятие");
        $mail->CharSet = 'Windows-1251';
        $mail->SingleTo = true;
        $mail->AddAddress($this->user->email, iconv('UTF-8', 'WINDOWS-1251', $this->user->name));
        $tpl = new Template();
        $tpl->assign('user', $this->user);
        $tpl->assign('order', $this->order);
        $mail->MsgHTML(iconv('UTF-8', 'WINDOWS-1251', $tpl->fetch('cabinet/mail/registration-event.tpl')));
        if (!$mail->Send()) {
            pre($mail);
        }
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    private function notifyNewUser(): void
    {
        $mail = new PHPMailer();
        $mail->From = "noreply@" . $_SERVER['SERVER_NAME'];
        $mail->FromName = iconv('UTF-8', 'WINDOWS-1251', "noreply@" . $_SERVER['SERVER_NAME']);
        $mail->Subject = iconv('UTF-8', 'WINDOWS-1251', "Регистрация на мероприятие");
        $mail->CharSet = 'Windows-1251';
        $mail->SingleTo = true;
        $mail->AddAddress($this->user->email, iconv('UTF-8', 'WINDOWS-1251', $this->user->name));
        $tpl = new Template();
        $tpl->assign('user', $this->user);
        $tpl->assign('order', $this->order);
        $tpl->assign('site', $_SERVER['SERVER_NAME']);
        $tpl->assign(
            'confirm_url',
            'https://' . $_SERVER['SERVER_NAME'] . $this->pathPrefix . '/confirm?token=' . $this->user->code
        );
        $tpl->assign('site', $_SERVER['SERVER_NAME']);
        $mail->MsgHTML(iconv('UTF-8', 'WINDOWS-1251', $tpl->fetch('cabinet/mail/registration-event-user.tpl')));
        if (!$mail->Send()) {
            pre($mail);
        }
    }

    private function generateConfirmation($user): string
    {
        return md5($user->email . substr(str_shuffle(str_repeat('ac27sdapw34mert289', 9)), 0, 9));
    }
}