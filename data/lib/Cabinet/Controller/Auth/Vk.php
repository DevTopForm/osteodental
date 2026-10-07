<?php

namespace App\Cabinet\Controller\Auth;

class Vk extends Model
{
    protected string $key = 'vk';

    protected function parseToken($response): array
    {
        $data = json_decode($response);
        return ['token' => $data->access_token, 'data' => ['user_id' => $data->user_id]];
    }

    protected function getUserParams($token): array
    {
        return [
            'access_token' => $token['token'],
            'uids' => $token['data']['user_id'],
            'fields' => 'photo'
        ];
    }

    protected function parseUser($response): array
    {
        $data = json_decode($response);
        $user = $data->response[0];
        return [
            'id' => $user->uid,
            'firstname' => $user->first_name,
            'lastname' => $user->last_name,
            'image' => $user->photo,
        ];
    }
}