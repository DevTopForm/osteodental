<?php

namespace App\Site;

use App\Item\Order;
use App\Node\Item;
use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;
use App\Site\Service\Message\Telegram as MessageTelegram;

class Telegram extends Push
{
    protected $type = "telegram";
    protected $orderId;
    protected $chatId;

    protected function getData()
    {
        $data = [];
        if (!empty($this->orderId)) {
            $personal = $this->getPersonal($this->orderId);
            $data = [
                "type" => $this->type,
                "user_phone" => $personal["phone"],
                "user_mail" => $personal["email"],
                "chat_id" => $this->chatId
            ];
        }
        return $data;
    }

    public function run()
    {
        $logger = new Logger();
        $writer = new Stream('log/db_change.log');
        $logger->addWriter($writer);
        $content = file_get_contents("php://input");
        if (empty($content)) {
            header('HTTP/1.0 403 Forbidden');
            die;
        }
        $content = json_decode($content, true);
        $logger->info($content);
        $text = explode(' ', $content["message"]["text"]);
        $this->chatId = $content["message"]["chat"]["id"];

        if ($text[0] == "/about") {
            $message = "Это бот интернет магазина template.devsrv.ru Сюда приходят уведомления о ваших заказах";
            $service = new MessageTelegram();
            $service->sendMessage($message, $this->chatId);
        } else {
            if (count($text) > 1) {
                $this->orderId = $text[1];
            }
            $this->activate();
        }
    }

    public function activate()
    {
        if (empty($this->orderId)) {
            $message = "Мы не знакомы. Что бы активировать аккаунт, закажите у нас что-нибудь";
        } else {
            if ($this->findChatId()) {
                $message = "Мы уже знакомы! Скорее переходите к нам в магазин и совершайте покупки";
            } else {
                $message = "Здравствуйте! Ваш аккаунт активирован. Теперь вы будете получать уведомления о заказах";
                $this->save();
            }
        }
        $service = new MessageTelegram();
        $service->sendMessage($message, $this->chatId);
        $this->orderNotification();
    }

    protected function findChatId()
    {
        Item::$itemsTable = "push_message";
        $find = Item::getByKey("chat_id", $this->chatId);
        if (!empty($find->id)) {
            return true;
        }
        return false;
    }

    protected function orderNotification()
    {
        $order = new Order($this->orderId);
        $number = date('d-m-Y', strtotime($order->date)) . "/" . $order->id;
        $message = 'Новый заказ №' . $number;
        $message .= '<code>' . PHP_EOL . '</code>';
        $message .= 'Магазин <a href="https://template.devsrv.ru">template.devsrv.ru</a>';
        $message .= '<code>' . PHP_EOL . '</code>';
        $message .= 'Клиент: <b>' . $order->firstname . ' ' . $order->phone . '</b>';
        $message .= '<code>' . PHP_EOL . '</code>';
        $message .= 'Способ доставки: <b>' . $order->deliveryTypeArray[$order->delivery] . '</b>';
        $message .= '<code>' . PHP_EOL . '</code>';
        $message .= 'Способ оплаты: <b>' . $order->deliveryPaymentMethodArray[$order->payment_method] . '</b>';
        $message .= '<code>' . PHP_EOL . '</code>';
        $message .= 'Состав заказа: ';
        $message .= '<code>' . PHP_EOL . '</code>';
        foreach ($order->data as $item) {
            $message .= '    ' . $item->title . '. ' . $item->price . ' x ' . $item->count;
            $message .= '<code>' . PHP_EOL . '</code>';
        }
        $message .= 'Сумма: ' . number_format($item->summ, 0, '', ' ') . ' руб';
        $service = new MessageTelegram();
        $message = urlencode($message);
        $service->sendMessage($message, $this->chatId);
    }

    public function find($order)
    {
        Item::$itemsTable = "push_message";
        $find = Item::getByKey("user_mail", $order->email);
        if (empty($find->id)) {
            $find = Item::getByKey("user_phone", $order->phone);
        }

        return $find;
    }
}