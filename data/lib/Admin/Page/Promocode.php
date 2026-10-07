<?php

namespace App\Admin\Page;

use App\Form\Multisel2area;
use App\Node\Item;
use App\Query;
use App\Item\Promocode as PromocodeItem;
use App\Utils;
use stdClass;

class Promocode extends LAVED
{

    protected $localTpl = 'content/promocode.tpl';
    protected $action = 'promocode';

    protected function setItemFields()
    {
    }

    protected function executeRequestProcessing()
    {
        parent::executeRequestProcessing();
        if ($this->state == self::STATE_LIST) {
            $this->updateList();
        } elseif ($this->state == self::STATE_EDIT) {
            $this->editItem();
        }
    }

    protected function updateList()
    {
        if (isset(Query::$post['remove']) && isset(Query::$post['list'])) {
            foreach (Query::$post['list'] as $item_id => $item) {
                if (isset($item)) {
                    $promocode = new PromocodeItem($item_id);
                    $promocode->delete();
                }
            }
            Utils::redirect($this->pathPrefix);
        }
    }

    protected function editItem()
    {
        if (isset(Query::$post['save']) && !empty(Query::$post['save'])) {
            $this->item = $this->getItem();
            $promocode = new PromocodeItem($this->item->id);

            $promocode->title = Query::$post['title'];
            $promocode->type = (!empty(Query::$post['type'])) ? Query::$post['type'] : 0;
            $promocode->code = Query::$post['code'];
            $promocode->sale = (!empty(Query::$post['sale'])) ? Query::$post['sale'] : 0;
            $promocode->products = Query::$post['products'];
            $promocode->nodes = Query::$post['nodes'];
            $promocode->active = (!empty(Query::$post['active'])) ? 1 : 0;

            if ($promocode->validate()) {
                $promocode->save();
                Utils::redirect($this->pathPrefix);
            } else {
                $this->errors = $promocode->errors;
            }
        }
    }

    protected function getListSorters()
    {
        return ['sorter' => 'ID DESC'];
    }

    protected function getItem()
    {
        return new PromocodeItem($this->extractItemId());
    }

    protected function getItemsList()
    {
        return PromocodeItem::getList($this->getParameters(), 50);
    }

    public static function getAllPromocodes()
    {
        $params = [
            "filters" => [
//                "public" => "public=1"
            ],
            "sorters" => [
                "sorter" => "ID DESC"
            ]
        ];
        return PromocodeItem::getList($params);
    }

    protected function getListFilters()
    {
        $params = [];
        return $params;
    }

    protected function parseStateEdit()
    {
        $tpl = $this->getItemsTpl();
        $this->item = $this->getItem();
        $tpl->assign('item', $this->prepareEditItemHtml($this->item));
        $tpl->assign(
            'products',
            $this->getInput('products', $this->getProducts('content_catalog', ['public = 1']))
        );
        $tpl->assign('nodes', $this->getInput('nodes', $this->getNodes()));
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->errors);
        return $tpl->fetch($this->localTpl);
    }

    private function getProducts($table = 'content_catalog', $filter = ['public = 1'])
    {
        Item::$itemsTable = $table;

        return Item::getList([
            'filters' => $filter,
            'sorters' => [
                'id ASC',
            ]
        ], null)->getItems();
    }


    private function getNodes()
    {
        return \App\Node::getList([
            'filters' => [
                'public = 1',
                'type IN ("catalog")'
            ],
            'sorters' => [
                'id ASC',
            ]
        ], null)->getItems();
    }


    public function getInput($name, $items)
    {
        $options = [];

        foreach ($items as $option) {
            $options[] = [
                "title" => str_replace('"', '\"', $option->title),
                "value" => $option->id,
            ];
        }

        $obj = new StdClass;
        $obj->options_data = $options;

        $field = new Multisel2area($obj);
        $field->setName($name);
        if ($this->item->$name) {
            $field->setValue(implode(",", $this->item->$name));
        }

        return $field->getHtml();
    }

    private function checkValue($value, $items)
    {
        if ($value && $items) {
            $value = explode(",", $value);
            foreach ($value as $val) {
                foreach ($items as $option) {
                    if ($option->id == $val) {
                        $result[] = $val;
                    }
                }
            }
            return ($result) ? implode(",", $result) : "";
        }
    }
}
