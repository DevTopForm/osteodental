<?php

namespace App\Admin;

use App\Message;
use App\User as AppUser;

class User extends AppUser
{
    protected $table = 'admin';

    public string $role = 'admin';

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData(): array
    {
        return [
            'login' => $this->login,
            'hash' => $this->hash,
            'role' => $this->role,
            'name' => $this->name,
            'active' => empty($this->active) ? 0 : 1,
            'lastlogin' => empty($this->lastlogin) ? date('Y-m-d H:i') : $this->lastlogin,
            'access' => join(';', $this->access),
            'secret' => empty($this->secret) ? '' : $this->secret,
        ];
    }

    protected function prepareData()
    {
        if (empty($this->access)) {
            $this->access = [];
        } else {
            $this->access = explode(';', $this->access);
        }
    }

    public function validate(): bool
    {
        $valid = true;
        if (empty($this->name)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить имя пользователя', 'error');
        }
        if (empty($this->login) || (!preg_match('/^[a-zA-Z0-9\._-]+$/u', $this->login) && !preg_match(
                    '/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/u',
                    $this->login
                ))) {
            $valid = false;
            $this->errors[] = new Message(
                'Необходимо правильно заполнить логин. <em>Допускается использование букв английского алфавита, цифр и знаков «.», «_», «-».</em>',
                'error'
            );
        }
        if (empty($this->id)) {
            $exists = static::getByKey('login', $this->login);
            if (!empty($exists->id)) {
                $valid = false;
                $this->errors[] = new Message('Пользователь с таким логином уже существует', 'error');
            }
        }
        if (!empty($this->new_pass)) {
            $this->hash = '';
            if ($this->new_pass != $this->new_pass_2) {
                $valid = false;
                $this->errors[] = new Message('Введенные пароли не совпадают', 'error');
            }
        }
        if (empty($this->hash) || empty($this->id)) {
            if (!empty($this->new_pass) && preg_match('/.{6,}/u', $this->new_pass)) {
                $this->hash = static::genHash($this->new_pass);
            } else {
                $valid = false;
                $this->errors[] = new Message(
                    'Необходимо заполнить пароль. <em>Длина пароля должна быть не менее 6ти символов.</em>', 'error'
                );
            }
        }
        return $valid;
    }

    public static function getUserByCredentials($login, $password)
    {
        return static::getByKeys([
            'active' => 1,
            'login' => $login,
            'hash' => static::genHash($password)
        ]);
    }

    public function hasAccess($action)
    {
        if ($this->role == 'sadmin') {
            return true;
        }
        return in_array($action, $this->access);
    }
}
