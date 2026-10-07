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

class Recovery extends \App\Cabinet\Page
{
    protected string $localTpl = 'cabinet/recovery.tpl';
    private array $errors = [];
    public string $state;
    public User $user;

    const STATE_RECOVERY = 'recovery';
    const STATE_CONFIRM = 'confirm';
    const STATE_SENDED = 'sended';
    const STATE_SUCCESS = 'success';

    protected function defineState(): void
    {
        if (empty($this->relativePath)) {
            $this->state = self::STATE_RECOVERY;
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
            self::STATE_RECOVERY => '/^recovery$/i',
            self::STATE_CONFIRM => '/^confirm$/i',
            self::STATE_SENDED => '/^sended$/i',
            self::STATE_SUCCESS => '/^success$/i',
        ];
    }

    /**
     * @throws NotFoundException
     */
    protected function executeRequestProcessing(): void
    {
        try {
            $user = LoginManager::getLoggedUser();
            Utils::redirect('/');
        } catch (Exception) {
        }
        if ($this->state == self::STATE_ERROR) {
            throw new NotFoundException(__CLASS__ . '-' . $this->relativePath);
        }
        if ($this->state == self::STATE_RECOVERY && !empty(Query::$post)) {
            $this->recoveryUser();
        }
        if ($this->state == self::STATE_CONFIRM) {
            $this->confirmUser();
        }
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws \Smarty\Exception
     */
    protected function recoveryUser(): void
    {
//        if (!empty(Query::$post['captcha'])) {
//            if (Query::$post['captcha'] == $_SESSION['captcha_recovery']) {
//                unset($_SESSION['captcha_recovery']);

                if (!empty(Query::$post['email'])) {

                    $user = User::getByEmail(trim(Query::$post['email']));
                    if (!empty($user->id)) {
                        $user->recovery = $this->generateConfirmation($user);
                        $user->save();
                        $this->user = $user;
                        $this->notifyUser();
                        Utils::redirect($this->pathPrefix . '/' . self::STATE_SENDED);
                    }
                }
                $this->errors[] = new Message('Неверно указан E-mail или такого пользователя не существует', 'error');
//            } else {
//                $this->errors[] = new Message('Неверно заполнен проверочный код', 'error');
//            }
//        } else {
//            $this->errors[] = new Message('Не заполнен проверочный код', 'error');
//        }
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws \Smarty\Exception
     */
    protected function confirmUser(): void
    {
        if (empty(Query::$get['token'])) {
            return;
        }
        $recoveredUser = User::recovery(Query::$get['token']);
        if (!empty($recoveredUser)) {
            $this->user = $recoveredUser;
            $this->notifyUser('newpass');
            Utils::redirect($this->pathPrefix . '/' . self::STATE_SUCCESS);
        }
        $this->errors[] = [
            'type' => 'error',
            'text' => 'Указан неверный код подтверждения'
        ];
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
    protected function parseStateRecovery(): string
    {
        $tpl = $this->getTpl();
        if (!empty(Query::$post['email'])) {
            $tpl->assign('email', Query::$post['email']);
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
    protected function parseStateSended(): string
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
    private function notifyUser($type = 'recovery'): void
    {
        $mail = new PHPMailer();

        $settings = Registry::get('settings');
        $from = $settings->getSiteParams('from_email');
        $site = $settings->getSiteParams('sitename');
        $mail->From = empty($from) ? ("noreply@" . $_SERVER['SERVER_NAME']) : $from;
        $mail->FromName = iconv('UTF-8', 'WINDOWS-1251', $site);
        $mail->Subject = iconv('UTF-8', 'WINDOWS-1251', "Восстановление пароля");
        $mail->CharSet = 'Windows-1251';
        $mail->AddAddress($this->user->email, iconv('UTF-8', 'WINDOWS-1251', $this->user->getName()));
        $mail->MsgHTML(iconv('UTF-8', 'WINDOWS-1251', $this->parseNotification($type)));
        if (!$mail->Send()) {
//            pre($mail->ErrorInfo);
//            var_dump(mail('ivan@topform.ru', 'Test', 'Test'));
//            die();
        }
    }

    /**
     * @throws \Smarty\Exception
     */
    private function parseNotification($template = 'recovery'): string
    {
        $tpl = new Template();
        $tpl->assign('user', $this->user);
        $tpl->assign('site', $_SERVER['SERVER_NAME']);
        $tpl->assign(
            'confirm_url',
            'https://' . $_SERVER['SERVER_NAME'] . '/cabinet/recovery/confirm?token=' . $this->user->recovery
        );
        return $tpl->fetch('cabinet/mail/' . $template . '.tpl');
    }

    private function generateConfirmation($user): string
    {
        return md5($user->email . substr(str_shuffle(str_repeat('ac27sdapw34mert289', 9)), 0, 9));
    }
}