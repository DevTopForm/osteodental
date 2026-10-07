<?php

namespace App\Cabinet\Page;

use App\Cabinet\LoginManager;
use App\Cabinet\User;
use App\Message;
use App\Query;
use App\Registry;
use App\Template;
use App\Utils;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Props\NotFoundException;

class Register extends \App\Cabinet\Page
{
    protected string $localTpl = 'cabinet/registration.tpl';

    private array $errors = [];
    private User|null $registerUser = null;
    private mixed $registerCompany = null;
    public User $user;

    const STATE_REGISTER = 'register';
    const STATE_SUCCESS = 'success';
    const STATE_CONFIRM = 'confirm';

    protected function defineState(): void
    {
        if (empty($this->relativePath)) {
            $this->state = self::STATE_REGISTER;
            return;
        }
        foreach ($this->getStateRegexps() as $state => $regexp) {
            if (preg_match($regexp, $this->relativePath)) {
                $this->state = $state;
                return;
            }
        }
        $this->state = self::STATE_ERROR;
    }

    protected function getStateRegexps(): array
    {
        return [
            self::STATE_REGISTER => '/^register$/i',
            self::STATE_SUCCESS => '/^success$/i',
            self::STATE_CONFIRM => '/^confirm$/i',
        ];
    }

    /**
     * @throws NotFoundException
     */
    protected function executeRequestProcessing(): void
    {
        try {
            LoginManager::getLoggedUser();
            Utils::redirect(SYS_CABINET_PATH_PREFIX);
        } catch (Exception) {
        }
        if ($this->state == self::STATE_ERROR) {
            throw new NotFoundException(__CLASS__ . '-' . $this->relativePath);
        }
        if ($this->state == self::STATE_REGISTER && !empty(Query::$post)) {
            try {
                $this->registerUser();
            } catch (\PHPMailer\PHPMailer\Exception|\Smarty\Exception) {
            }
        }
        if ($this->state == self::STATE_CONFIRM) {
            $this->confirmUser();
        }
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws \Smarty\Exception
     */
    protected function registerUser(): void
    {
        $user = new User();
        $user->type = Query::$post['type'] ?? '';
        $user->firstname = strip_tags(Query::$post['firstname']);
        $user->lastname = strip_tags(Query::$post['lastname']);
        $user->middlename = strip_tags(Query::$post['middlename']);
        $user->email = strip_tags(Query::$post['email']);
        $user->login = $user->email;
        $user->active = 0;
        $user->new_pass = Query::$post['pass'];
        $user->new_pass_2 = Query::$post['pass_2'];
        $user->regdate = date("Y-m-d H:i");
        $user->phone = isset(Query::$post['phone']) ? strip_tags(Query::$post['phone']) : '';
        if (!empty(Query::$post['captcha'])) {
            if (Query::$post['captcha'] == $_SESSION['captcha_register']) {
                unset($_SESSION['captcha_register']);
            } else {
                $user->errors[] = new Message('Неверно заполнен проверочный код', 'error');
            }
        } else {
            $user->errors[] = new Message('Не заполнен проверочный код', 'error');
        }
        if ($user->validate() && empty($user->errors)) {
            $user->code = $this->generateConfirmation($user);
            $user->save();
            $this->user = $user;
            $this->notifyUser();
            Utils::redirect($this->pathPrefix . '/' . self::STATE_SUCCESS);
        } else {
            $this->errors = $user->errors;
            $this->registerUser = $user;
        }
    }

    protected function confirmUser(): void
    {
        if (empty(Query::$get['token'])) {
            return;
        }
        $activated = User::activate(Query::$get['token']);
        if (!empty($activated->id)) {
            $lm = new LoginManager();
            $lm->remoteLogin($activated);
            Utils::redirect(SYS_CABINET_PATH_PREFIX);
        }
        $this->errors[] = new Message('Указан неверный код подтверждения', 'error');
    }

    protected function parseContent()
    {
        $method = sprintf('parseState%s', ucfirst($this->state));
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return sprintf('Пока не определено отображение для состояния: %s. Метод: %s', $this->state, $method);
    }

    protected function getTpl(): Template
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('state', $this->state);
        return $tpl;
    }

    /**
     * @throws \Smarty\Exception
     */
    protected function parseStateRegister(): string
    {
        $tpl = $this->getTpl();
        if (!is_null($this->registerUser)) {
            $tpl->assign('user', $this->registerUser);
        }
        if (!is_null($this->registerCompany)) {
            $tpl->assign('company', $this->registerCompany);
        }
        $tpl->assign('errors', $this->errors);
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws \Smarty\Exception
     */
    protected function parseStateSuccess(): string
    {
        $tpl = $this->getTpl();
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws \Smarty\Exception
     */
    protected function parseStateConfirm(): string
    {
        $tpl = $this->getTpl();
        $tpl->assign('errors', $this->errors);
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws \Smarty\Exception
     */
    private function notifyUser(): void
    {
        $mail = new PHPMailer();
        $settings = Registry::get('settings');
        $from = $settings->getSiteParams('from_email');
        $site = $settings->getSiteParams('sitename');
        $mail->From = empty($from) ? ("noreply@" . $_SERVER['SERVER_NAME']) : $from;
        $mail->FromName = iconv('UTF-8', 'WINDOWS-1251', $site);
        $mail->Subject = iconv('UTF-8', 'WINDOWS-1251', "Регистрация на сайте");
        $mail->CharSet = 'Windows-1251';
        $mail->AddAddress($this->user->email, iconv('UTF-8', 'WINDOWS-1251', $this->user->name));
        $mail->MsgHTML(iconv('UTF-8', 'WINDOWS-1251', $this->parseNotification()));
        if (!$mail->Send()) {
            pre($mail);
        }
    }

    /**
     * @throws \Smarty\Exception
     */
    private function parseNotification(): string
    {
        $tpl = new Template();
        $tpl->assign('user', $this->user);
        $tpl->assign('site', $_SERVER['SERVER_NAME']);
        $tpl->assign(
            'confirm_url',
            'https://' . $_SERVER['SERVER_NAME'] . $this->pathPrefix . '/confirm?token=' . $this->user->code
        );
        return $tpl->fetch('cabinet/mail/registration.tpl');
    }

    private function generateConfirmation($user): string
    {
        return md5($user->email . substr(str_shuffle(str_repeat('ac27sdapw34mert289', 9)), 0, 9));
    }
}
