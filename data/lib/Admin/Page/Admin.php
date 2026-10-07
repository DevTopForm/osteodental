<?php

namespace App\Admin\Page;

use App\Admin\Action;
use App\Admin\User;
use App\Query;
use App\Utils;
use App\Item\History as ItemHistory;

class Admin extends LAVED
{
    protected $localTpl = 'content/admin.tpl';
    protected $action = 'admin';

    protected function setItemFields()
    {
        $this->item->name = strip_tags(Query::$post['name']);
        $this->item->login = strip_tags(Query::$post['login']);

        if (!empty(Query::$post['newpass'])) {
            $this->item->new_pass = Query::$post['newpass'];
            $this->item->new_pass_2 = Query::$post['newpass2'];
        }
        if ($this->user->id != $this->item->id) {
            $this->item->active = empty(Query::$post['active']) ? 0 : 1;
            $this->item->access = array();
            if (!empty(Query::$post['access']) && is_array(Query::$post['access'])) {
                $actions = $this->getAvailableActions();
                $keys = array();
                foreach ($actions as $action) {
                    $keys[] = $action->action;
                }
                foreach (Query::$post['access'] as $access) {
                    if (in_array($access, $keys)) {
                        $this->item->access[] = $access;
                    }
                }
            }
        }
    }

    protected function executeRequestProcessing()
    {
        parent::executeRequestProcessing();
    }

    protected function getItem()
    {
        $user = new User($this->extractItemId());

        if ($this->user->role == 'sadmin') {
            return $user;
        } else {
            if ($user->role == 'sadmin') {
                Utils::redirect($this->pathPrefix);
            }
            return $user;
        }
    }

    protected function getItemsList()
    {
        return User::getList($this->getParameters());
    }

    protected function getListFilters()
    {
        if ($this->user->role == 'sadmin') {
            return array();
        } else {
            return array(
                'role' => 'role = "admin"'
            );
        }
    }

    protected function getAvailableActions()
    {
        $actions = Action::getList(array('filters' => array('access = 1')))->getItems();
        foreach ($actions as $key => $action) {
            if ($this->user->role != 'sadmin' && !in_array($action->action, $this->user->access)) {
                unset($actions[$key]);
            }
        }
        return $actions;
    }

    protected function getSpecialEditData()
    {
        return array(
            'actions' => $this->getAvailableActions(),
            'errors' => $this->errors
        );
    }

    protected function editItem()
    {
        $this->item = $this->getItem();
        if (empty(Query::$post['save'])) {
            return;
        }
        $this->setItemFields();
        if ($this->item->validate()) {
            $this->item->save();
            $this->afterSaveItem();
        }
        $this->errors = $this->item->errors;
    }

    protected function afterSaveItem()
    {
        ItemHistory::add("Администраторы", "/adm/admin");
        Utils::redirect($this->pathPrefix);
    }

    protected function afterDeleteItem()
    {
        ItemHistory::add("Администраторы", "/adm/admin");
        Utils::redirect($this->pathPrefix);
    }
}