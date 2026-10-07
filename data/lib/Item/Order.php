<?php

namespace App\Item;

use App\Cabinet\User;
use App\Item\Order\Data;
use App\Item\Order\Payment;
use App\Item\Order\Status;
use App\Message;
use App\Model;
use App\Registry;
use App\Site\Service\Message\Telegram;
use App\Site\Telegram as SiteTelegram;
use PHPMailer\PHPMailer\PHPMailer;

class Order extends Model
{

    protected $table = 'order_shop';
    protected $defaultSorter = 'date';
    protected $defaultOrder = 'DESC';

    public $date;
    public $user;
    public $lastname;
    public $firstname;
    public $middlename;
    public $country;
    public $city;
    public $address;
    public $email;
    public $phone;
    public $delivery;
    public $comment;
    public $payment_method;
    public $PaymentUrl;
    public $summ;
    public $from;
    public $from_comment;
    public $promo_num;
    public $paynum;
    public $status;
    public $payway;
    public $instagram;
    public $promocode;

    public $deliveryTypeArray = [
        1 => 'Самовывоз',
        2 => 'Курьером',
    ];

    public $deliveryPaymentMethodArray = [
        1 => 'Банковская карта',
        2 => 'СБП',
        3 => 'Наличные',
        4 => 'Кредит',
        5 => 'Счёт',
    ];

    protected function prepareData()
    {
        if (!empty($this->user)) {
            $this->user = new User($this->user);
        }
        if (!empty($this->status)) {
            $this->status = new Status($this->status);
        }

        if (!empty($this->payment_method)) {
            $payment = new Payment();
            $this->payment_method = $payment->getList()[$this->payment_method] ?? '';
        }

        $this->data = Data::getList(array('filters' => array('`order` = ' . $this->id)))->getItems();
    }

    protected function insertAction()
    {
        if ($this->data) {
            foreach ($this->data as $item) {
                $order_item = new Data();
                $order_item->order = $this->id;
                $order_item->title = $item->title . (isset($item->variant["id"]) ? ' ' . $item->variant["size"] . ' ' . $item->variant["height"] : '');
                $order_item->image = !empty($item->image) ? $item->image->id : 0;
                $order_item->price = $item->variant->price ?? $item->price;
                $order_item->count = $item->count;
                $order_item->summ = (isset($item->variant->price) ? $item->variant->price * $item->count : $item->price * $item->count);
                $order_item->itemId = $item->id;
                $order_item->itemVariant = (isset($item->variant["id"]) ? $item->variant["id"] : null);
                $order_item->itemType = get_class($item);

                if ($order_item->validate()) {
                    $order_item->save();
                }
            }
        }
    }

    protected function getData()
    {
        $data = [
            'date' => empty($this->date) ? date('Y-m-d H:i:s', time()) : $this->date,
            'user' => !isset($this->user->id) ? 0 : $this->user->id,
            'type' => !isset($this->type) ? '' : $this->type,
            'lastname' => empty($this->lastname) ? '' : $this->lastname,
            'firstname' => empty($this->firstname) ? '' : $this->firstname,
            'middlename' => empty($this->middlename) ? '' : $this->middlename,
            'email' => empty($this->email) ? '' : $this->email,
            'status' => !isset($this->status->id) ? 0 : $this->status->id,
            'comment' => empty($this->comment) ? '' : $this->comment,
            'phone' => empty($this->phone) ? '' : $this->phone,
            'instagram' => empty($this->instagram) ? '' : $this->instagram,
            'promocode' => empty($this->promocode) ? '' : $this->promocode,
            'country' => empty($this->country) ? '' : $this->country,
            'city' => empty($this->city) ? '' : $this->city,
            'address' => empty($this->address) ? '' : $this->address,
            'delivery' => !isset($this->delivery) ? 0 : $this->delivery,
            'deliverySumm' => !isset($this->deliverySumm) ? 0 : $this->deliverySumm,
            'payment_method' => $this->payment_method->getCode(),
            'orderSumm' => empty($this->orderSumm) ? 0 : $this->orderSumm,
            'saleSumm' => empty($this->saleSumm) ? 0 : $this->saleSumm,
            'totalSumm' => $this->totalSumm ?: ($this->orderSumm ?: 0 + $this->deliverySumm ?: 0),
        ];

        return $data;
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function setFields($fields)
    {
        $order_fileds = get_class_vars(get_class($this));
        if (!empty($fields)) {
            foreach ($fields as $field) {
                $name = $field->name;
                if (array_key_exists($name, $order_fileds)) {
                    $this->$name = $field->field->getValue();
                } else {
                    $this->comment .= sprintf('%s: %s <br/>', $field->title, $field->field->getValue());
                }
            }
        }
    }

    public function validate()
    {
        $valid = true;

        if (empty($this->user->id) && empty($this->firstname)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Имя»', 'error');
        }
        if (empty($this->phone)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Телефон»', 'error');
        }
        if (empty($this->data)) {
            $valid = false;
            $this->errors[] = new Message('Товары отсутствуют', 'error');
        }
        if (!preg_match('/^[\w\-\.]+@([\w-]+\.)+[\w\-]{2,4}$/u', $this->email)) {
            $valid = false;
            $this->errors[] = new Message(
                'Неверный формат адреса электронной почты. <em>Пример: v.pupkin@gmail.com.</em>', 'error'
            );
        }

        if (empty($this->payment_method)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо выбрать «Способ оплаты»', 'error');
        }

        return $valid;
    }

    public function notify($type = 'make')
    {
        $this->notifyAdmin($type);
        $this->notifyUser($type);
        $this->notifyTelegram($this->id);
    }

//    public function notifyTelegram($type = 'make')
//    {
//        $settings = Registry::get('settings');
//        $service = new Telegram();
//        $siteTelegram = new SiteTelegram();
//        $find = $siteTelegram->find($this);
//        $number = date('d-m-Y', strtotime($this->date)) . "/" . $this->id;
//        $message = 'Новый заказ №' . $number;
//        $message .= '<code>' . PHP_EOL . '</code>';
//        $message .= 'Магазин <a href="https://template.devsrv.ru">template.devsrv.ru</a>';
//        $message .= '<code>' . PHP_EOL . '</code>';
//        $message .= 'Клиент: <b>' . $this->firstname . ' ' . $this->phone . '</b>';
//        $message .= '<code>' . PHP_EOL . '</code>';
//        $message .= 'Способ доставки: <b>' . $this->deliveryTypeArray[$this->delivery] . '</b>';
//        $message .= '<code>' . PHP_EOL . '</code>';
//        $message .= 'Способ оплаты: <b>' . $this->deliveryPaymentMethodArray[$this->payment_method] . '</b>';
//        $message .= '<code>' . PHP_EOL . '</code>';
//        $message .= 'Состав заказа: ';
//        $message .= '<code>' . PHP_EOL . '</code>';
//        foreach ($this->data as $item) {
//            $message .= '    ' . $item->title . '. ' . $item->price . ' x ' . $item->count;
//            $message .= '<code>' . PHP_EOL . '</code>';
//        }
//        $message .= 'Сумма: ' . number_format($this->totalSumm, 0, '', ' ') . ' руб';
//
//        $message = urlencode($message);
//        if (!empty($find->id)) {
//            $service->sendMessage($message, $find->chat_id);
//        }
//
//        $admin_chat_id = $settings->getSiteParams('chat_id');
//        if (!empty($admin_chat_id)) {
//            $service->sendMessage($message, $admin_chat_id);
//        }
//    }

    public function notifyAdmin($type = 'make')
    {
        $settings = Registry::get('settings');

        $email = $settings->getSiteParams('email');
        if (empty($email)) {
            $email = $settings->getSiteParams('email');
        }

        $site = $settings->getSiteParams('sitename');


        $subject = sprintf('На сайте %s оформлен заказ', $site);

        $mail = new PHPMailer();
        $from = $settings->getSiteParams('from_email');
        //$mail->From     = empty($from) ? ("noreply@".$_SERVER['SERVER_NAME']) : $from;
        $mail->From = "no-reply@" . $_SERVER['SERVER_NAME'];
        $mail->FromName = iconv('UTF-8', 'WINDOWS-1251', $site);
        $mail->Subject = iconv('UTF-8', 'WINDOWS-1251', $subject);
        $mail->CharSet = 'Windows-1251';
        $mail->SingleTo = true;
        $mail->ContentType = 'text/html';
        if (!empty($email)) {
            $mail->AddAddress($email, $email);
        }

        $content = '
            <html>
                <head><title>' . $subject . '</title></head>
                <body>
                    <h3>' . $subject . '</h3>
                    <p><strong>ФИО</strong>: ' . $this->lastname . ' ' . $this->firstname . ' ' . $this->middlename . '</p>
                    <p><strong>Заказ оформлен</strong>: ' . $this->date . '</p>
                    <p><strong>Номер заказа</strong>: ' . date("d.m.Y/", strtotime($this->date)) . $this->id . '</p>
                    <p><strong>Статус заказа</strong>: ' . $this->status->title . '</p>
                    <p><strong>Телефон</strong>: ' . $this->phone . '</p>
                    <p><strong>E-mail</strong>: ' . $this->email . '</p>
                    ' . ((!empty($this->country)) ? '<p><strong>Страна</strong>: ' . $this->country . '</p>' : '') . '
                    ' . ((!empty($this->city)) ? '<p><strong>Город</strong>: ' . $this->city . '</p>' : '') . '
                    ' . ((!empty($this->address)) ? '<p><strong>Адрес</strong>: ' . $this->address . '</p>' : '') . '
                    <p><strong>Доставка</strong>: ' . $this->deliveryTypeArray[$this->delivery] . '</p>
                    <p><strong>Способ оплаты</strong>: ' . $this->payment_method->getName() . '</p>
                    <p><strong>Комментарий</strong>: ' . $this->comment . '</p>
                    <br>
                    <p><strong>Состав заказа:</strong></p>
                    ' . $this->getBasketToMail() . '
                    <br>
                    <p><strong>Стоимость доставки</strong>: ' . $this->deliverySumm . '</p>
                    <p><strong>Стоимость заказа</strong>: ' . $this->orderSumm . '</p>
                    <p><strong>Итого</strong>: ' . $this->totalSumm . '</p>
                </body>
            </html>
        ';

        $mail->MsgHTML(iconv('UTF-8', 'WINDOWS-1251', $content));
        @$mail->Send();
    }

    public function notifyTelegram($order_id){
        $order = Order::getByKey('id', $order_id);

        if(empty($order->id)){
            return false;
        }

        $settings = Registry::get('settings');
        $service = new Telegram();
        $arIds = $settings->getSiteParams('chat_id');
        $arIds = explode(',', $arIds);

        $site =  $settings->getSiteParams('sitename');
        $subject  = sprintf('На сайте %s новый заказ ',$site);
        $message = 	$subject;
        $message .= '<code>'.PHP_EOL.'</code>';

        $message .= '<b>ФИО</b>: ' . $order->lastname . ' ' . $order->firstname . ' ' . $order->middlename;
        $message .= '<code>'.PHP_EOL.'</code>';
        $message .= '<b>Заказ оформлен</b>: ' . $order->date;
        $message .= '<code>'.PHP_EOL.'</code>';
        $message .= '<b>Номер заказа</b>: ' . date("d.m.Y/", strtotime($order->date)) . $order->id;
        $message .= '<code>'.PHP_EOL.'</code>';
        $message .= '<b>Статус заказа</b>: ' . $order->status->title;
        $message .= '<code>'.PHP_EOL.'</code>';
        $message .= '<b>Телефон</b>: ' . $order->phone;
        $message .= '<code>'.PHP_EOL.'</code>';
        $message .= '<b>E-mail</b>: ' . $order->email;
        $message .= '<code>'.PHP_EOL.'</code>';
        $message .= ((!empty($order->country)) ? '<b>Страна</b>: ' . $order->country . '<code>'.PHP_EOL.'</code>' : '');
        $message .= ((!empty($order->address)) ? '<b>Адрес</b>: ' . $order->address . '<code>'.PHP_EOL.'</code>' : '');
        $message .= '<b>Способ оплаты</b>: ' . $this->payment_method->getName();
        $message .= '<code>'.PHP_EOL.'</code>';
        $message .= '<b>СОСТАВ ЗАКАЗА</b>';
        $message .= '<code>'.PHP_EOL.'</code>';

        foreach ($order->data as $item){
            $message .= '<b>Наименование:</b> <a href="https://' . $_SERVER['HTTP_HOST'] . ($item->url ?: $item->item?->getUrl()) . '">' . $item->title . ($item->artikul ? " (Артикул: " . $item->artikul . ")" : "" ) . '</a>';
            $message .= ' <b>Количество:</b> ' . $item->count;
            $message .= ' <b>Цена:</b> ' . $item->price;
            $message .= ' <b>Сумма:</b> ' . $item->summ;
            $message .= '<code>'.PHP_EOL.'</code>';
            $message .= '<code>'.PHP_EOL.'</code>';
        }

        $message .= '<b>Стоимость заказа</b>: ' . $order->orderSumm;
        $message .= '<code>'.PHP_EOL.'</code>';
        $message .= '<b>Итого</b>: ' . $order->totalSumm;
        $message .= '<code>'.PHP_EOL.'</code>';

        $message = urlencode($message);

        if(!empty($arIds)) {
            foreach ($arIds as $chat_id) {
                if (!empty($chat_id)) {
                    $service->sendMessage($message, trim($chat_id));
                }
            }
        }
    }

    public function notifyUser($type = 'make')
    {
        $settings = Registry::get('settings');
        $site = $settings->getSiteParams('sitename');

        if ($type == 'canPay') {
            $subject = sprintf('На сайте %s Ваш заказ готов к оплате', $site);
        } else {
            if ($type == 'make') {
                $subject = sprintf('На сайте %s Вы оформили заказ', $site);
            }
        }

        $email = $this->email;

//        $siteTelegram = new SiteTelegram();
//        $find = $siteTelegram->find($this);

        $mail = new PHPMailer();
        $from = $settings->getSiteParams('from_email');
        //$mail->From     = empty($from) ? ("noreply@".$_SERVER['SERVER_NAME']) : $from;
        $mail->From = "no-reply@" . $_SERVER['SERVER_NAME'];
        $mail->FromName = iconv('UTF-8', 'WINDOWS-1251', $site);
        $mail->Subject = iconv('UTF-8', 'WINDOWS-1251', $subject);
        $mail->CharSet = 'Windows-1251';
        $mail->SingleTo = true;
        $mail->ContentType = 'text/html';
        if (!empty($email)) {
            $mail->AddAddress($email, $email);
        }

        if ($type == 'canPay') {
            $content = '
            <html>
                <head><title>' . $subject . '</title></head>
                <body>
                    <h3>' . $subject . '</h3>
                    <p><strong>ФИО</strong>: ' . $this->lastname . ' ' . $this->firstname . ' ' . $this->middlename . '</p>
                    <p><strong>Заказ оформлен</strong>: ' . $this->date . '</p>
                    <p><strong>Номер заказа</strong>: ' . date("d.m.Y/", strtotime($this->date)) . $this->id . '</p>
                    <p><strong>Статус заказа</strong>: ' . $this->status->title . '</p>
                    <p><strong>Телефон</strong>: ' . $this->phone . '</p>
                    <p><strong>E-mail</strong>: ' . $this->email . '</p>
                    ' . ((!empty($this->country)) ? '<p><strong>Страна</strong>: ' . $this->country . '</p>' : '') . '
                    ' . ((!empty($this->city)) ? '<p><strong>Город</strong>: ' . $this->city . '</p>' : '') . '
                    ' . ((!empty($this->address)) ? '<p><strong>Адрес</strong>: ' . $this->address . '</p>' : '') . '
                    <p><strong>Способ оплаты</strong>: ' . $this->payment_method->getName() . '</p>
                    <p><strong>Комментарий</strong>: ' . $this->comment . '</p>                    
                    <br>
                    <p><strong>Состав заказа:</strong></p>
                    ' . $this->getBasketToMail() . '
                    <br>
                    <p><strong>Стоимость заказа</strong>: ' . $this->orderSumm . '</p>
                    <p><strong>Итого</strong>: ' . $this->totalSumm . '</p>
                    <p><strong>Ссылка на оплату</strong>: <a href="' . $this->PaymentUrl . '">' . $this->PaymentUrl . '</a></p>
                    <br>
                    <br>
                </body>
            </html>
            ';
        } else {
            if ($type == 'make') {
                $content = '
                <html>
                    <head><title>' . $subject . '</title></head>
                    <body>
                        <h3>' . $subject . '</h3>
                        <p><strong>ФИО</strong>: ' . $this->lastname . ' ' . $this->firstname . ' ' . $this->middlename . '</p>
                        <p><strong>Заказ оформлен</strong>: ' . $this->date . '</p>
                        <p><strong>Номер заказа</strong>: ' . date("d.m.Y/", strtotime($this->date)) . $this->id . '</p>
                        <p><strong>Статус заказа</strong>: ' . $this->status->title . '</p>
                        <p><strong>Телефон</strong>: ' . $this->phone . '</p>
                        <p><strong>E-mail</strong>: ' . $this->email . '</p>
                        ' . ((!empty($this->country)) ? '<p><strong>Страна</strong>: ' . $this->country . '</p>' : '') . '
                        ' . ((!empty($this->city)) ? '<p><strong>Город</strong>: ' . $this->city . '</p>' : '') . '
                        ' . ((!empty($this->address)) ? '<p><strong>Адрес</strong>: ' . $this->address . '</p>' : '') . '
                        <p><strong>Способ оплаты</strong>: ' . $this->payment_method->getName() . '</p>
                        <p><strong>Комментарий</strong>: ' . $this->comment . '</p>
                        <br>
                        <p><strong>Состав заказа:</strong></p>
                        ' . $this->getBasketToMail() . '
                        <br>
                        <p><strong>Стоимость заказа</strong>: ' . $this->orderSumm . '</p>
                        <p><strong>Итого</strong>: ' . $this->totalSumm . '</p>
                        <br>
                        <br>
                    </body>
                </html>
            ';
            }
        }

        $mail->MsgHTML(iconv('UTF-8', 'WINDOWS-1251', $content));
        @$mail->Send();
    }

    public function getPaymentUrl()
    {
        return '';
    }

    private function getBasketToMail()
    {
        if (!empty($this->data)) {
            $basket = '
				<table border="1" width="100%">
					<tr>
						<th>Наименование</th>
						<th>Количество</th>
						<th>Стоимость</th>
						<th>Сумма</th>
					<tr>';
            foreach ($this->data as $item) {
                $basket .= '
                        <tr>
                            <td><a href="http://' . $_SERVER['HTTP_HOST'] . ($item->url ?: $item->getUrl()) . '">' . $item->title . '</a></td>
                            <td>' . $item->count . '</td>
                            <td>' . $item->price . ' руб.</td>
                            <td>' . ($item->summ) . ' руб.</td>
                        <tr>
                        ';
            }
            $basket .= '</table>';

            return $basket;
        }
    }

    public function isNew():bool
    {
        return !empty($this->status->is_new);
    }
}