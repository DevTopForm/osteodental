<?php

namespace App\Site\Service\Message;

class Telegram extends Model
{
    protected $apiKey = "8312144480:AAHrOPg9WTKJZ1T4T_CiPejZI1YDNtQGq68";

    public function __construct()
    {
    }

    public function sendMessage($text, $chatId)
    {
        $url = "https://api.telegram.org/bot" . $this->apiKey . "/sendMessage?chat_id=$chatId&text=" . $text . "&parse_mode=html";
        $result = $this->sendQuery($url);
        return $result;
    }

    public function getUpdates()
    {
        $url = "https://api.telegram.org/bot" . $this->apiKey . "/getUpdates?limit=1&offset=-1";
        $result = $this->sendQuery($url);
        $result = json_decode($result, true);
        return $result;
    }

    public function setWebhook()
    {
        $url = "https://api.telegram.org/bot" . $this->apiKey . "/getUpdates";
    }

    public function getChatMember()
    {
        $url = "https://api.telegram.org/bot" . $this->apiKey . "/getChatMember?chat_id=514339401&user_id=514339401";
        $result = $this->sendQuery($url);
        $result = json_decode($result, true);
        return $result;
    }

    public function getChat()
    {
        $url = "https://api.telegram.org/bot" . $this->apiKey . "/getChat?chat_id=514339401";
        $result = $this->sendQuery($url);
        $result = json_decode($result, true);
        return $result;
    }

    protected function addContact()
    {
    }
}