<?php

namespace App\Cabinet;

use App\Image;
use App\Message;
use App\Registry;
use App\User as AppUser;
use DateTime;

class User extends AppUser
{

    protected $table = 'user';

    public ?string $new_pass;
    public ?string $new_pass_2;
    public string $type;
    protected bool $lazy_save = false;
    protected array $params;

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    // дополнительная обработка свойств объекта
    protected function prepareData(): void
    {
        if (!empty($this->image)) {
            $this->image = new Image($this->image);
        }
        $this->title = trim(sprintf("%s %s %s", $this->lastname, $this->firstname, $this->middlename));
        if (!empty($this->favorite)) {
            $this->favorite = explode(',', $this->favorite);
        }
        if (!empty($this->themes)) {
            $this->themes = explode(',', $this->themes);
        }
    }

    public function validate(): bool
    {
        $valid = true;
        if (empty($this->firstname)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Имя»', 'error');
        }
        if (empty($this->lastname) && (empty($this->isOrderCreated))) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Фамилия»', 'error');
        }
        if (empty($this->social_type)) {
            if (empty($this->email) || !preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/u', $this->email)) {
                $valid = false;
                $this->errors[] = new Message(
                    'Неверный формат адреса электронной почты. <em>Пример: v.pupkin@gmail.com.</em>', 'error'
                );
            } else {
                $exists = static::getByLogin($this->login);
                if (empty($this->id) && !empty($exists->id)) {
                    $valid = false;
                    $this->errors[] = new Message('Пользователь с таким E-mail уже существует', 'error');
                } elseif (!empty($this->id) && !empty($exists->id) && $exists->id != $this->id) {
                    $valid = false;
                    $this->errors[] = new Message('Пользователь с таким E-mail уже существует', 'error');
                }
            }
        }
        if (empty($this->id) && empty($this->new_pass)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо указать пароль', 'error');
        }
        if (!empty($this->new_pass)) {
            $this->hash = '';
            if (empty($this->new_pass_2)) {
                $valid = false;
                $this->errors[] = new Message('Необходимо ввести подтверждение пароля', 'error');
            } elseif ($this->new_pass != $this->new_pass_2) {
                $valid = false;
                $this->errors[] = new Message('Введенные пароли не совпадают', 'error');
            }
        }
        if (empty($this->hash) || empty($this->id)) {
            if (!empty($this->new_pass) && preg_match('/.{4,}/u', $this->new_pass)) {
                $this->hash = static::genHash($this->new_pass);
            } else {
                $valid = false;
                $this->errors[] = new Message(
                    'Необходимо заполнить пароль. <em>Длина пароля должна быть не менее 4x символов.</em>', 'error'
                );
            }
        }
        return $valid && empty($this->errors);
    }

    public static function activate($code): false|User
    {
        $user = static::getByKey('code', $code);
        if (empty($user->id)) {
            return false;
        }
        $user->active = 1;
        $user->code = '';
        $user->save();
        return $user;
    }

    public static function recovery($code): false|User
    {
        $user = static::getByKey('recovery', $code);
        if (empty($user->id)) {
            return false;
        }
        $user->recovery = '';
        $user->new_pass = static::genPass();
        $user->hash = static::genHash($user->new_pass);
        $user->save();
        return $user;
    }

    public function getData(): array
    {
        return [
            'firstname' => empty($this->firstname) ? '' : $this->firstname,
            'lastname' => empty($this->lastname) ? '' : $this->lastname,
            'middlename' => empty($this->middlename) ? '' : $this->middlename,
            'email' => empty($this->email) ? '' : $this->email,
            'login' => empty($this->login) ? '' : $this->login,
            'active' => empty($this->active) ? 0 : 1,
            'hash' => empty($this->hash) ? '' : $this->hash,
            'code' => empty($this->code) ? '' : $this->code,
            'recovery' => empty($this->recovery) ? '' : $this->recovery,
            'phone' => empty($this->phone) ? '' : $this->phone,
            'regdate' => empty($this->regdate) ? null : $this->regdate,
            'lastlogin' => empty($this->lastlogin) ? null : $this->lastlogin,
            'image' => empty($this->image) ? 0 : $this->image->id,
            'social_type' => empty($this->social_type) ? null : $this->social_type,
            'social_acc' => empty($this->social_acc) ? null : $this->social_acc,
            'social_block' => empty($this->social_block) ? 0 : 1,
            'social_img' => empty($this->social_img) ? '' : $this->social_img,
            'favorite' => empty($this->favorite) ? '' : implode(',', $this->favorite),
            'subscribe' => empty($this->subscribe) ? 0 : 1,
            'themes' => empty($this->themes) ? '' : implode(',', $this->themes),
            'sale' => empty($this->sale) ? 0 : $this->sale,
            'sale_last_update' => empty($this->sale_last_update) ? null : $this->sale_last_update,
            'instagramm_login' => empty($this->instagramm_login) ? null : $this->instagramm_login,
        ];
    }

    public function prepareDelete(): void
    {
        if (!empty($this->image)) {
            $this->image->delete();
        }
    }

    public static function getByLogin($login): false|User
    {
        return static::getByKey('login', $login);
    }

    public static function getByEmail($email): false|User
    {
        return static::getByKey('email', $email);
    }

    public static function getByCredentials($login, $password): false|User
    {
        return static::getByKeys(['login' => $login, 'hash' => static::genHash($password)]);
    }

    public function getName(): string
    {
        return trim(sprintf('%s %s %s', $this->lastname, $this->firstname, $this->middlename));
    }

    /*
    * Персональная скидка Cabinet_User
    * @return float размер скидки в %.
    */

    public function getPersonalDiscount()
    {
        if (empty($this->sale) || $this->sale == 0) {
            $this->sale = 0;
        }
        if (empty($this->sale_last_update)) {
            $this->sale_last_update = $this->regdate;
        }
        $last_update = new DateTime;
        $last_update->setTimeStamp(strtotime($this->sale_last_update));

        $diff = $last_update->diff(new DateTime)->y;
        if ($diff > 0) {
            if (empty($this->params)) {
                $this->params = Registry::get('settings')->getSiteParams(0);
            }
            if ($this->sale == $this->params['sale_personal_max']) {
                return $this->sale;
            }

            $sale = $this->sale + $diff * floatval($this->params['sale_personal_step']);

            if ($sale > $this->params['sale_personal_max']) {
                $sale = $this->params['sale_personal_max'];
            }
            $this->sale = $sale;
            $this->sale_last_update = $last_update->modify("+$diff year")->getTimestamp();
            $this->lazy_save();
        }
        return $this->sale;
    }

    public function lazy_save(): void
    {
        $this->lazy_save = true;
    }

    public function getShortName(): string
    {
        return sprintf('%s %s.', $this->firstname, mb_substr($this->lastname, 0, 1));
    }

    public function getLetter(): string
    {
        return mb_substr($this->firstname, 0, 1);
    }
}
