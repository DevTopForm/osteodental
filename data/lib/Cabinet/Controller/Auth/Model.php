<?php

namespace App\Cabinet\Controller\Auth;

use App\Cabinet\LoginManager;
use App\Cabinet\User;
use App\Params;
use App\Query;
use App\Registry;
use Exception;
use Laminas\Http\Request;
use Laminas\Http\Client;

abstract class Model
{
    protected string $key = 'default';

    protected mixed $params = [];

    public function __construct()
    {
        $params = Registry::get('config');
        $this->params = $params['auth'][$this->key];
    }

    /**
     * @throws Exception
     */
    public function run(): true
    {
        if (empty(Query::$request['code'])) {
            throw new Exception('Ошибка в запросе');
        }
        $token = $this->getToken(Query::$request['code']);
        if (!empty($token['token'])) {
            $userinfo = $this->getUserInfo($token);
            if (!empty($userinfo['id'])) {
                $user = $this->saveUser($userinfo);
                $this->login($user);
                return true;
            }
        }
        throw new Exception('Ошибка авторизации');
    }

    protected function getTokenParams($code): array
    {
        return [
            'client_id' => $this->params['id'],
            'client_secret' => $this->params['hash'],
            'code' => $code,
            'redirect_uri' => 'https://' . Params::$params['public']['site']['host'] . $this->params['return'],
        ];
    }

    /**
     * @throws Exception
     */
    protected function getToken($code): array
    {
        try {
            $client = new Client();
            $client->setUri($this->params['request']['token']['url']);
            $client->setOptions(['timeout' => 100]);
            if ($this->params['request']['token']['type'] == 'GET') {
                $client->setMethod(Request::METHOD_GET);
                $client->setParameterGet($this->getTokenParams($code));
                //$response = $client->request(Zend_Http_Client::GET);
            } else {
                $client->setMethod(Request::METHOD_POST);
                $client->setParameterPost($this->getTokenParams($code));
                //$response = $client->request(Zend_Http_Client::POST);
            }
            $response = $client->send();
            if ($response->isError()) {
                throw new Exception();
            }
            return $this->parseToken($response->getBody());
        } catch (Exception $e) {
            throw new Exception('Failed request');
        }
    }

    protected function parseToken($response): array
    {
        $data = json_decode($response);
        return ['token' => $data->access_token, 'data' => []];
    }

    protected function getUserParams($token): array
    {
        return [
            'access_token' => $token['token'],
            'fields' => 'id,name,picture'
        ];
    }

    /**
     * @throws Exception
     */
    protected function getUserInfo($token): array
    {
        try {
            $client = new Client();
            $client->setUri($this->params['request']['user']['url']);
            $client->setConfig(['timeout' => 100]);
            if ($this->params['request']['user']['type'] == 'GET') {
                $client->setMethod(Request::METHOD_GET);
                $client->setParameterGet($this->getUserParams($token));
                $response = $client->send();
                //$response = $client->request(Zend_Http_Client::GET);
            } else {
                $client->setMethod(Request::METHOD_POST);
                $client->setParameterPost($this->getUserParams($token));
                $response = $client->send();
                //$response = $client->request(Zend_Http_Client::POST);
            }
            if (!$response->isOk()) {
                throw new Exception();
            }
            return $this->parseUser($response->getBody());
        } catch (Exception $e) {
            throw new Exception('Failed request');
        }
    }

    protected function parseUser($response): array
    {
        $data = json_decode($response);
        return [
            'id' => $data->id,
            'firstname' => $data->first_name,
            'lastname' => $data->last_name,
            'image' => $data->picture,
        ];
    }

    protected function saveUser($info): false|User
    {
        $user = User::getByKeys(['social_type' => $this->key, 'social_acc' => $info['id']]);
        if (empty($user)) {
            $user = new User();
            $user->regdate = date('Y-m-d H:i');
            $user->active = 1;
            $user->lastlogin = date('Y-m-d H:i');
            $user->social_type = $this->key;
            $user->social_acc = $info['id'];
        }
        if (empty($user->social_block)) {
            $user->firstname = $info['firstname'];
            $user->lastname = $info['lastname'];
            if (!empty($info['image'])) {
                $user->social_img = $info['image'];
            }
        }
        $user->save();
        return $user;
    }

    protected function login($user): void
    {
        $lm = new LoginManager();
        $lm->logout();
        $lm->user = $user;
        $lm->rememberUser();
    }
}
