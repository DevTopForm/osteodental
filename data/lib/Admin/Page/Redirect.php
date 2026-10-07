<?php

namespace App\Admin\Page;

use App\Query;
use App\Utils;
use App\Item\Redirect as ItemRedirect;
use App\Item\History as ItemHistory;

class Redirect extends LAVED {

    protected $localTpl = 'content/redirect.tpl';
    protected $action = 'redirect';

    private $_fields = [
        'from' => [
            'type' => 'text',
            'title' => 'Откуда'
        ],
        'to' => [
            'type' => 'text',
            'title' => 'Куда'
        ],
        'public' => [
            'type' => 'checkbox',
            'title' => 'Активен',
        ],
    ];

    protected function setItemFields(){
    }

    protected function executeRequestProcessing(){
        parent::executeRequestProcessing();
        if ($this->state == self::STATE_LIST) {
            $this->updateList();
        } elseif ($this->state == self::STATE_EDIT){
            $this->editItem();
        }
    }

    protected function updateList(){
        if (isset(Query::$post['remove']) && isset(Query::$post['list'])) {
            foreach (Query::$post['list'] as $item_id => $item) {
                if (isset($item)) {
                    $comment = new ItemRedirect($item_id);
                    $comment->delete();
                }
            }
            ItemHistory::add("Редиректы", "/adm/redirect");
            Utils::redirect($this->pathPrefix);
        }
    }

    protected function editItem(){
        if (isset(Query::$post['save']) && !empty(Query::$post['save'])) {
            $this->item = $this->getItem();
            $order = new ItemRedirect($this->item->id);

            $order->from = Query::$post['from'];
            $order->to = Query::$post['to'];
            $order->public = (!empty(Query::$post['public'])) ? 1 : 0;

            $order->save();

            ItemHistory::add("Редиректы", "/adm/redirect");
            Utils::redirect($this->pathPrefix);
        }
    }

    protected function getListSorters(){
        return array('sorter' => 'ID DESC');
    }

    protected function getItem(){
        return new ItemRedirect($this->extractItemId());
    }

    protected function getItemsList(){

        return ItemRedirect::getList($this->getParameters(),10);
    }

    protected function getListFilters(){
        $params = array();

        if(isset(Query::$get['filter']) && !empty(Query::$get['filter'])){
            foreach(Query::$get['filter'] AS $key => $val){
                if(!empty($key) && !empty($val)){
                    $params[] = "`$key` like '%$val%'";
                }
            }
        }

        return $params;
    }

    protected function parseStateEdit(){
        $tpl = $this->getItemsTpl();
        $this->item = $this->getItem();
        $tpl->assign('item',$this->prepareEditItemHtml($this->item));
        $tpl->assign('data',$this->getSpecialEditData());
        $tpl->assign('errors',$this->item->errors);
        return $tpl->fetch($this->localTpl);
    }

    protected function getSpecialEditData()
    {
        return [
            'fields' => $this->_fields
        ];
    }
}
