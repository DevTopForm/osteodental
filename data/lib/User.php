<?php

namespace App;

use ReflectionProperty;

class User extends Model
{
    protected $table = 'user';

    public string $title;
    public string $name;
    public string $lastname;
    public string $firstname;
    public string $middlename;
    public string $login;
    public string $hash;
    public string $email;
    public ?string $lastlogin;
    public int $active;
    public string $code;
    public string $role;
    public ?string $recovery;
    public ?float $sale;
    public ?string $sale_last_update;
    public ?string $regdate;
    public ?string $instagramm_login;
    public string $phone;
    public $subscribe;

    public function __construct($id = 0, $data = [])
    {
        parent::__construct($id, $data);

        if (!$this->id) {
            foreach (get_class_vars(__CLASS__) as $prop => $val) {
                $rp = new ReflectionProperty(static::class, $prop);

                if ($rp->getType()) {
                    $val = $val ?: match ($rp->getType()->getName()) {
                        "string" => "",
                        "int" => 0,
                        default => null,
                    };

                    $this->$prop = $val;
                }
            }
        }
    }

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
            'email' => $this->email,
            'role' => $this->role,
            'name' => $this->name,
            'active' => $this->active,
            'code' => $this->code,
        ];
    }

    public static function genHash($str): string
    {
        $md5str = md5($str);
        $pre_salt = substr($md5str, 0, 12);
        $post_salt = substr($md5str, -12, 12);
        return md5($post_salt . $pre_salt);
    }

    public function validate(): bool
    {
        return true;
    }

    public function updateLastLogin(): void
    {
        $this->lastlogin = date("Y-m-d H:i:s");
        $this->save();
    }

    public static function genPass(): string
    {
        return substr(str_shuffle(str_repeat('a678hjwr234yuxcdefgzk059', 9)), 0, 9);
    }
}
