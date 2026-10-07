<?php

namespace App\Cabinet;

use Exception;

class LoginManager
{
    protected int $status = 0;
    public User|bool $user = false;

    const EMPTY_LOGIN_ERROR = 1;
    const BAD_CREDENTIALS_ERROR = 2;
    const POLICY_ERROR = 3;

    public function login(): void
    {
        if (self::isUserLogged()) {
            return;
        }
        $this->checkInput();
        $this->processLogin();
        $this->rememberUser();
    }

    public function status(): int
    {
        return $this->status;
    }

    /**
     * @throws Exception
     */
    protected function checkInput(): void
    {
        if (empty($_POST['email_']) || empty($_POST['password_'])) {
            $this->status = self::EMPTY_LOGIN_ERROR;
            throw new Exception("Empty login/password", $this->status);
        }

        if (empty($_POST['policy'])) {
            $this->status = self::POLICY_ERROR;
            throw new Exception("Empty login/password", $this->status);
        }
    }

    /**
     * @throws Exception
     */
    public static function getLoggedUser(): User
    {
        if (!self::isUserLogged()) {
            throw new Exception('Not logged');
        }
        $user = new User($_SESSION['userId']);
        if (empty($user->id)) {
            throw new Exception('Non-existent user');
        }
        return $user;
    }

    public function logout(): void
    {
        unset($_SESSION['userId'], $_SESSION['userAgent']);
    }

    public static function isUserLogged(): bool
    {
        return !empty($_SESSION['userId']) && !empty($_SESSION['userAgent']) && ($_SESSION['userAgent'] == md5(
                    $_SERVER['HTTP_USER_AGENT']
                ));
    }

    /**
     * @throws Exception
     */
    protected function processLogin(): void
    {
        $this->getUserByCredentials($_POST['email_'], $_POST['password_']);
        if (false === $this->user) {
            $this->status = self::BAD_CREDENTIALS_ERROR;
            throw new Exception("Wrong login/password", $this->status);
        }
    }

    protected function getUserByCredentials($login, $password): void
    {
        $this->user = User::getByCredentials($login, $password);
    }

    public function rememberUser(): void
    {
        $_SESSION['userAgent'] = md5($_SERVER['HTTP_USER_AGENT']);
        $_SESSION['userId'] = $this->user->id;
        $this->user->updateLastLogin();
    }

    public function remoteLogin($user): void
    {
        $this->user = $user;
        $this->rememberUser();
    }

    public static function getErrorMessageByCode(int $code = 0): string
    {
        return match ($code) {
            self::EMPTY_LOGIN_ERROR => 'Поля логин и пароль обязательны для заполнения',
            self::BAD_CREDENTIALS_ERROR => 'Вы ввели неверный логин или пароль',
            self::POLICY_ERROR => 'Вы должны подтвердить, что ознакомненны и согласны с политикой конфиденциальности',
            default => 'Неизвестная ошибка',
        };
    }
}
