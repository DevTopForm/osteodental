<?php

namespace App\Form;

use App\Message;
use App\Query;

class Captchagoogle extends Text
{

    //получить ключи - https://www.google.com/recaptcha/
    protected $class = "text g-recaptcha";
    protected $type = "text";
    protected $size = "compact"; //or normal
    protected $data_theme = "light"; //or dark
    protected $data_type = "image"; //or audio
    protected $sitekey = "6LdAmDEUAAAAAIWd26yaPzSIqwrFDOHgpR6u_mEG";
    protected $google_url = "https://www.google.com/recaptcha/api/siteverify";
    protected $secret = '6LdAmDEUAAAAAA3EZuKW1AggY5aj471JCyOliT3s';

    public function getHtml()
    {
        $this->value = '';
        return sprintf(
            '<div class="%s" id="%s" data-sitekey="%s" data-size="%s"></div>',
            $this->class,
            $this->name,
            $this->sitekey,
            $this->size
        );
    }

    public function validate()
    {
        $this->setCaptchaGoogle();
        if (!empty($this->value)) {
            $url = $this->google_url . "?secret=" . $this->secret . "&response=" . $this->value . "&remoteip=" . $_SERVER['REMOTE_ADDR'];
            $answer = $this->getCurlData($url);
            $answer = json_decode($answer, true);
            if (!$answer['success']) {
                $this->messages[] = new Message('Неверно заполнена reCaptcha', 'error');
            }
        } else {
            $this->messages[] = new Message('Неверно заполнена reCaptcha', 'error');
        }
        return $this->messages;
    }

    protected function getCurlData($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt(
            $curl,
            CURLOPT_USERAGENT,
            "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-EU; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16"
        );
        $curlData = curl_exec($curl);
        curl_close($curl);
        return $curlData;
    }

    public function setCaptchaGoogle()
    {
        if (isset(Query::$post['g-recaptcha-response'])) {
            $this->value = Query::$post['g-recaptcha-response'];
        }
    }
}

?>