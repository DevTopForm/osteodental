<?php

namespace App\Admin\Controller\Ajax;

use App\Item\Widget;
use App\Node as AppNode;
use App\Node\Item as Item;
use App\Node\Catalog\Item as CatalogItem;
use App\Query;

class Node extends Action
{

    protected $tpl = '';

    public function run()
    {
        switch ($this->path[0]) {
            case 'field':
                $this->saveField();
                break;
        }
    }

    protected function saveField()
    {
        $node = Query::$post['node'];
        if($node == 'widget') {
            Widget::simpleSave((int)Query::$post['itemid'], Query::$post['field'], Query::$post['value']);
            echo true;
            die();
        }

        $node = new AppNode((int)$node);

        if (empty($node->id)) {
            throw new \Exception('Не найден раздел');
        }

        $item = ($node->type->is_catalog) ? new CatalogItem($node->getTable(), (int)Query::$post['itemid']) : new Item($node->getTable(), (int)Query::$post['itemid']);
        if (empty($item->id)) {
            throw new \Exception('Не найден элемент раздела');
        }
        $fields = $node->getFields();
        $field = null;
        foreach ($fields as $nodefield) {
            if (Query::$post['field'] == $nodefield->name) {
                $field = $nodefield;
                break;
            }
        }

        if ($node->type->is_catalog) {
            $fields = $node->getCatalogFields();
            foreach ($fields as $nodefield) {
                if (Query::$post['field'] == $nodefield->name) {
                    $field = $nodefield;
                    break;
                }
            }
        }

        if (empty($field->id)) {
            throw new \Exception('Не найдено поле');
        }
        $value = Query::$post['value'];
        if ($field->field == "date") {
            $value = (int)($value / 1000);
        }
        Query::$post[$field->name] = $value;
        $messages = $field->validate();
        if (empty($messages)) {
            $item->simpleUpdate($field->name, $field->getValue());
            echo "true";
        } else {
            print_r($messages);
        }
        die;
    }
}