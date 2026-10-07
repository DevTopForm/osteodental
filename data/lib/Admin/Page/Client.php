<?php

namespace App\Admin\Page;

use App\Cabinet\User;
use App\Query;
use App\Item\Order as ItemOrder;
use App\Utils;
use App\Item\History as ItemHistory;

class Client extends LAVED
{

    protected $localTpl = 'content/client.tpl';
    protected $action = 'client';

    private $_fields = [
        'lastname' => [
            'type' => 'text',
            'title' => 'Фамилия'
        ],
        'firstname' => [
            'type' => 'text',
            'title' => 'Имя'
        ],
        'middlename' => [
            'type' => 'text',
            'title' => 'Отчество',
            'data' => [],
        ],
        'email' => [
            'type' => 'email',
            'title' => 'E-mail/Логин',
        ],
        'phone' => [
            'type' => 'phone',
            'title' => 'Телефон'
        ],
        'newpass' => [
            'type' => 'password',
            'title' => 'Новый пароль'
        ],
        'newpass2' => [
            'type' => 'password',
            'title' => 'Повторите пароль'
        ],
        'active' => [
            'type' => 'checkbox',
            'title' => 'Активен',
        ],
    ];

    protected function setItemFields()
    {
        $this->item->firstname = strip_tags(Query::$post['firstname']);
        $this->item->lastname = strip_tags(Query::$post['lastname']);
        $this->item->middlename = strip_tags(Query::$post['middlename']);
        $this->item->email = strip_tags(Query::$post['email']);
        $this->item->phone = strip_tags(Query::$post['phone']);
        $this->item->active = empty(Query::$post['active']) ? 0 : 1;
        $this->item->sale_last_update = date("Y-m-d H:i:s", time());
        if (empty($this->item->social_type)) {
            $this->item->login = $this->item->email;
            if (!empty(Query::$post['newpass'])) {
                $this->item->new_pass = Query::$post['newpass'];
                $this->item->new_pass_2 = Query::$post['newpass2'];
            }
        }
    }

    protected function getItem()
    {
        return new User($this->extractItemId());
    }

    protected function getItemsList()
    {
        return User::getList($this->getParameters());
    }

    protected function getSpecialEditData()
    {
        return [
            'fields' => $this->_fields
        ];
    }

    protected function parseStateEdit()
    {
        $tpl = $this->getItemsTpl();
        if (!empty($this->item->id)) {
            $tpl->assign('orders', $this->getOrders($this->item->id));
        }
        $tpl->assign('item', $this->prepareEditItemHtml($this->item));
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->item->errors);
        return $tpl->fetch($this->localTpl);
    }

    public function getOrders($id)
    {
        return ItemOrder::getList(['filters' => ['user = ' . $id], 'sorters' => ['id ASC']],
            null)->getItems();
    }

    protected function getListFilters()
    {
        $params = array();

        if (isset(Query::$get['filter']) && !empty(Query::$get['filter'])) {
            foreach (Query::$get['filter'] as $key => $val) {
                if (!empty($key) && !empty($val)) {
                    $params[] = "`$key` LIKE '%$val%'";
                }
            }
        }

        return $params;
    }

    protected function afterSaveItem()
    {
        ItemHistory::add("Клиенты", "/adm/client");
        Utils::redirect($this->pathPrefix);
    }

    protected function afterDeleteItem()
    {
        ItemHistory::add("Клиенты", "/adm/client");
        Utils::redirect($this->pathPrefix);
    }
}