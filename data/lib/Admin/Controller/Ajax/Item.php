<?php

namespace App\Admin\Controller\Ajax;

use App\Item\Order;
use App\Model;
use App\Query;

class Item extends Node
{

    protected $tpl = '';

    private $_models = [
        'order' => Order::class,
    ];

    protected function saveField()
    {
        $item = Query::$post['item'] ?? '';
        $field = Query::$post['field'] ?? '';
        $id = Query::$post['itemid'] ?? '';
        $value = Query::$post['value'] ?? '';

        if (
            empty($item)
            || empty($field)
            || empty($id)
            || empty($this->_models[$item])
        ) {
            die();
        }

        if (is_subclass_of($this->_models[$item], Model::class)) {
            $this->_models[$item]::simpleSave($id, $field, $value);
        }

        die();
    }
}