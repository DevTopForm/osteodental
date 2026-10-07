<?php

namespace App\Admin\Page;

use App\Query;
use App\Utils;
use App\Item\Widget as ItemWidget;
use App\Item\History as ItemHistory;

class Widget extends LAVED {

    protected $localTpl = 'content/widget.tpl';
    protected $action = 'widget';

    protected function editItem(){
        if (isset(Query::$post['save']) && !empty(Query::$post['save'])) {
            $this->item = $this->getItem();
            $order = new ItemWidget($this->item->id);

            $order->name = Query::$post['name'] ?? '';
            $order->title = Query::$post['title'] ?? '';
            $order->icon = Query::$post['icon'] ?? '';
            $order->public = !empty(Query::$post['public']) ? 1 : 0;
            $order->is_show = !empty(Query::$post['is_show']) ? 1 : 0;
            $order->metric_id = Query::$post['metric_id'];
            $order->metric_token = Query::$post['metric_token'];

            $order->save();

            ItemHistory::add("Виджеты", "/adm/widget");
            Utils::redirect($this->pathPrefix);
        }
    }

    protected function getItem(){
        return new ItemWidget($this->extractItemId());
    }

    protected function getItemsList(){

        return ItemWidget::getList($this->getParameters(),50);
    }
}
