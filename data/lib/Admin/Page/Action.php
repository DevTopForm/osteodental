<?php

namespace App\Admin\Page;

use App\Query;
use App\Utils;
use App\Admin\Action as AdminAction;
use App\Item\History as ItemHistory;

class Action extends LAVED
{

    protected $localTpl = 'content/action.tpl';
    protected $action = 'action';

    protected function setItemFields()
    {
        $this->item->action = strtolower(Utils::translit(strip_tags(Query::$post['action'])));
        $this->item->title = strip_tags(Query::$post['title']);
        $this->item->link = strip_tags(Query::$post['link']);
        $this->item->icon = strip_tags(Query::$post['icon']);
        $this->item->class = strip_tags(Query::$post['class']);
        $this->item->menu = empty(Query::$post['menu']) ? 0 : 1;
        $this->item->info = empty(Query::$post['info']) ? 0 : 1;
        $this->item->access = empty(Query::$post['access']) ? 0 : 1;
        $this->item->parent = empty(Query::$post['parent']) ? 0 : (int)Query::$post['parent'];
    }

    protected function getItem()
    {
        return new AdminAction($this->extractItemId());
    }

    protected function getItemsList()
    {
        return AdminAction::getList($this->getParameters());
    }

    protected function getSpecialEditData()
    {
        return array(
            'action' => AdminAction::getTree(),
        );
    }

    protected function afterSaveItem()
    {
        ItemHistory::add("Действия администраторов", "/adm/action");
        Utils::redirect($this->pathPrefix);
    }

    protected function afterDeleteItem()
    {
        ItemHistory::add("Действия администраторов", "/adm/action");
        Utils::redirect($this->pathPrefix);
    }
}