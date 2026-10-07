<?php

namespace App\Cabinet\Controller;

use App\Cabinet\Controller;
use App\Cabinet\LoginManager;
use App\Params;
use App\Query;
use App\Registry;
use App\Utils;
use Exception;

class Login extends Controller
{
    public function isDispatchable($pathStr): bool
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match('/^(login|logout)(\/.*)?$/', $pathStr);
    }

    public function run(): void
    {
        $path = $this->removePathPrefix(join('/', $this->path));
        $path = explode('/', $path);
        $lm = new LoginManager();
        $params = Registry::get('config');
        if ('login' == reset($path)) {
            if (!empty(Query::$request['frompage'])) {
                $_SESSION['last_page'] = Query::$request['frompage'];
            }
            if (!empty($path[1])) {
                switch ($path[1]) {
                    case 'vk':
                        $auth = $params['auth']['vk'];
                        Utils::redirect(
                            sprintf(
                                'https://oauth.vk.com/authorize?client_id=%s&response_type=code&redirect_uri=%s',
                                $auth['id'],
                                'https://' . Params::$params['public']['site']['host'] . $auth['return']
                            )
                        );
                        break;
                }
            }
            try {
                $lm->login();
                if (!empty($_SERVER['HTTP_REFERER'])) {
                    Utils::redirectPrevious();
                } else {
                    Utils::redirect('/cabinet/');
                }
            } catch (Exception $e) {
                Utils::redirect('/cabinet/?login_error=' . $e->getCode());
            }
        }
        if ('logout' == reset($path)) {
            $lm->logout();
            if (!empty($_SERVER['HTTP_REFERER'])) {
                Utils::redirectPrevious();
            } else {
                Utils::redirect('/cabinet/');
            }
        }
    }
}
