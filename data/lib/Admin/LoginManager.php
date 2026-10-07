<?php

namespace App\Admin;

class LoginManager
{
    protected
        $observers = array();
    protected
        $status = 0;
    public
        $user = false;

    const EMPTY_LOGIN_ERROR = 1;
    const EMPTY_PASSWORD_ERROR = 2;
    const BAD_CREDENTIALS_ERROR = 3;
    const BAD_IP_ERROR = 3;

    public function login()
    {
        if (self::isUserLogged()) {
            return;
        }
        $this->checkInput();
        $this->processLogin();
        $this->rememberUser();
    }

    public function status()
    {
        return $this->status;
    }

    protected function checkInput()
    {
        if (empty($_POST['login_'])) {
            $this->status = self::EMPTY_LOGIN_ERROR;
            throw new \Exception("Empty login", $this->status);
        }

        if (empty($_POST['password_'])) {
            $this->status = self::EMPTY_PASSWORD_ERROR;
            throw new \Exception("Empty password", $this->status);
        }
    }

    public static function getLoggedUser()
    {
        if (!self::isUserLogged()) {
            throw new \Exception('Not logged');
        }
        $user = new User($_SESSION['adminUserId']);
        if (empty($user->id)) {
            throw new \Exception('Unexisting user');
        }
        return $user;
    }

    public function logout()
    {
        unset($_SESSION['adminUserId'], $_SESSION['adminUserAgent']);
    }

    protected static function isUserLogged()
    {
        return !empty(
            $_SESSION['adminUserId']
            )
            && (
                $_SERVER['HTTP_USER_AGENT'] == 'Shockwave Flash'
                || (
                    !empty($_SESSION['adminUserAgent'])
                    && ($_SESSION['adminUserAgent'] == md5($_SERVER['HTTP_USER_AGENT'])
                    )
                )
            );
    }

    protected function processLogin()
    {
        $this->getUserByCredentials($_POST['login_'], $_POST['password_']);
        if (false === $this->user) {
            $this->status = self::BAD_CREDENTIALS_ERROR;
            throw new \Exception("Wrong login/password", $this->status);
        }
    }

    protected function getUserByCredentials(
        $login,
        $password
    )
    {
        $this->user = User::getUserByCredentials($login, $password);
    }

    public function rememberUser()
    {
        $_SESSION['adminUserAgent'] = md5($_SERVER['HTTP_USER_AGENT']);
        $_SESSION['adminUserId'] = $this->user->id;
        $this->user->updateLastLogin();
    }

    public static function getErrorInfo(): array
    {
        return [
            self::EMPTY_LOGIN_ERROR => [
                'field' => 'login_',
                'text' => 'Пустой логин'
            ],
            self::EMPTY_PASSWORD_ERROR => [
                'field' => 'password_',
                'text' => 'Пустой пароль'
            ],
            self::BAD_CREDENTIALS_ERROR => [
                'field' => 'password_',
                'text' => 'Неверный логин или пароль'
            ],
        ];
    }
}
