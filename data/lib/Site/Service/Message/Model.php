<?php

namespace App\Site\Service\Message;

abstract class Model{

    public function __construct(){

    }

    protected function sendQuery($url, $data = [], $method = 'get'){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $headers = [];
        if($method == 'post'){
            $headers[] = "Accept: application/json, text/plain, */*";
            $headers[] = "Content-Type: application/json;charset=UTF-8";
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        $answer = curl_exec($ch);
        curl_close($ch);

        return $answer;
    }

    public function query($data){

    }
}