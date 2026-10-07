<?php

namespace App\Cabinet\Page;

use App\Image;
use App\Item\Order;
use App\Message;
use App\Query;
use App\Template;
use App\Utils;
use Smarty\Exception;

class Profile extends Model
{
    protected string $localTpl = 'cabinet/profile.tpl';
    protected array $errors = [];
    protected string $menuActive = 'profile';

    const STATE_VIEW = 'view';
    const STATE_EDIT = 'edit';

    protected function defineState(): void
    {
        if (empty($this->relativePath)) {
            $this->state = self::STATE_EDIT;
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
            self::STATE_VIEW => '/^view$/i',
            self::STATE_EDIT => '/^edit$/i',
        ];
    }

    protected function executeRequestProcessing(): void
    {
        if ($this->state == self::STATE_EDIT && !empty(Query::$post)) {
            $this->editUser();
        }
    }

    protected function editUser(): void
    {
        if (empty(Query::$post['save'])) {
            return;
        }

        if (Query::$post['action'] == 'photo') {
            if (!empty(Query::$post['del_image'])) {
                if (!empty($this->user->image)) {
                    $this->user->del_image = $this->user->image;
                    $this->user->image = 0;
                }
            } elseif (!empty(Query::$files['image']['tmp_name'])) {
                if (!empty($this->user->image)) {
                    $this->user->del_image = $this->user->image;
                    $this->user->image = 0;
                }
                $image = new Image();
                $image->upload(Query::$files['image'], 'user');
                if (!empty($image->id)) {
                    $this->user->image = $image;
                }
            }
        } elseif (Query::$post['action'] == 'main') {
            $fio = explode(' ', Query::$post['fio'] ?? '');
            $this->user->firstname = trim($fio[1] ?? '');
            $this->user->lastname = trim($fio[0] ?? '');
            $this->user->middlename = trim($fio[2] ?? '');
            $this->user->email = strip_tags(Query::$post['email'] ?? '');
            $this->user->phone = strip_tags(Query::$post['phone'] ?? '');
            $this->user->instagramm_login = strip_tags(Query::$post['instagramm_login'] ?? '');
        } elseif (Query::$post['action'] == 'password') {
            if (empty($this->user->social_type)) {
                $this->user->new_pass = Query::$post['pass'];
                $this->user->new_pass_2 = Query::$post['pass_2'];
            }
        }

        if ($this->user->validate()) {
            $this->user->save();
            Utils::redirect(sprintf('%s?success=%s', $this->pathPrefix, Query::$post['action']));
        } else {
            $this->errors = $this->user->errors;
        }
    }

    protected function parseContent()
    {
        $method = sprintf('parseState%s', ucfirst($this->state));
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return sprintf('Пока не определено отображение для состояния: %s. Метод: %s', $this->state, $method);
    }

    protected function getUsersTpl(): Template
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('state', $this->state);
        return $tpl;
    }

    /**
     * @throws Exception
     */
    protected function parseStateView(): string
    {
        $tpl = $this->getUsersTpl();
        $orders = Order::getList(['filters' => ['user = ' . $this->user->id], 'sorters' => ['date DESC']],
            5)->getItems();
        $tpl->assign('user', $this->user);
        $tpl->assign('orders', $orders);
        $this->rightpart = false;
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws Exception
     */
    protected function parseStateEdit(): string
    {
        $tpl = $this->getUsersTpl();
        $tpl->assign('user', $this->user);
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->errors);
        $tpl->assign('message', $this->getMessage());
        return $tpl->fetch($this->localTpl);
    }

    protected function getSpecialEditData(): array
    {
        $years = [];
        $cur = date('Y', time());
        for ($i = 0; $i <= 80; $i++) {
            $y = $cur - $i;
            $years[$y] = $y;
        }
        $days = [];
        for ($i = 1; $i <= 31; $i++) {
            $days[$i] = $i;
        }
        return [
            'months' => [
                1 => 'январь',
                2 => 'февраль',
                3 => 'март',
                4 => 'апрель',
                5 => 'май',
                6 => 'июнь',
                7 => 'июль',
                8 => 'август',
                9 => 'сентябрь',
                10 => 'октябрь',
                11 => 'ноябрь',
                12 => 'декабрь'
            ],
            'years' => $years,
            'days' => $days,
        ];
    }

    public function getMessage(): string
    {
        return match (Query::$get['success'] ?? ''){
            'main' => (new Message('Данные успешно обновлены', 'success'))->html,
            'password' => (new Message('Пароль изменен', 'success'))->html,
            default => ''
        };
    }
}
