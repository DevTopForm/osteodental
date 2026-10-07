<?php

namespace App\Admin\Page;

use App\Admin\Controller\Ajax\Item;
use App\Item\History as ItemHistory;
use App\Query;
use App\Utils;

use App\Item\Order as ItemOrder;
use App\Item\Order\Status;

class Order extends LAVED
{

    protected $localTpl = 'content/order.tpl';
    protected $action = 'order';

    private $_dt_format = 'd.m.Y';

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
                    $comment = new ItemOrder($item_id);
                    $comment->delete();
                }
            }
            Utils::redirect($this->pathPrefix);
        }
    }

    protected function editItem()
    {
        if (isset(Query::$post['save']) && !empty(Query::$post['save'])) {
            $this->item = $this->getItem();
            $this->item->status = new Status(Query::$post['status']);
            $this->item->tracking = Query::$post['tracking'];

            if ($this->item->validate()) {
                $this->item->save();
                ItemHistory::add("Заказы", "/adm/order");
            }
        }
    }

    protected function getListSorters()
    {
        return ['sorter' => 'ID DESC'];
    }

    protected function getItem()
    {
        if (empty($this->item)) {
            $this->item = new ItemOrder($this->extractItemId());
        }

        return $this->item;
    }

    protected function getItemsList()
    {
        return ItemOrder::getList($this->getParameters(), $this->getLimit());
    }

    protected function parseStateEdit()
    {
        $tpl = $this->getItemsTpl();
        $this->item = $this->getItem();
        $tpl->assign('item', $this->prepareEditItemHtml($this->item));
        $tpl->assign('payments', $this->item->deliveryPaymentMethodArray);
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->item->errors);
        return $tpl->fetch($this->localTpl);
    }

    protected function getListFilters()
    {
        $filter = [];
        if (!empty(Query::$get['search_text'])) {
            $filter['search'] = "id LIKE '%" . Query::$get['search_text'] . "%' OR firstname LIKE '%" . Query::$get['search_text'] . "%' OR phone LIKE '%" . Query::$get['search_text'] . "%' OR email LIKE '%" . Query::$get['search_text'] . "%'  OR totalSumm LIKE '%" . Query::$get['search_text'] . "%'";
        }

        if (!empty(Query::$get['status']) && Query::$get['status'] !== 'all') {
            $filter['status'] = "status=" . intval(Query::$get['status']);
        }

        if (!empty(Query::$get['before_date'])) {
            $dt_before = \DateTime::createFromFormat($this->_dt_format, Query::$get['before_date']);
            $filter['before_date'] = "date <='" . $dt_before->format('Y-m-d H:i:s') . "'";
        }

        if (!empty(Query::$get['after_date'])) {
            $dt_after = \DateTime::createFromFormat($this->_dt_format, Query::$get['after_date']);
            $filter['after_date'] = "date >='" . $dt_after->format('Y-m-d H:i:s') . "'";
        }

        return $filter;
    }

    protected function getSpecialEditData()
    {
        return [
            'statuses' => Status::getList(['filters' => [], 'sorters' => ['id ASC']], null)->getItems()
        ];
    }

    protected function getSpecialListData()
    {
        return [
            'statuses' => Status::getList(['filters' => [], 'sorters' => ['id ASC']], null)->getItems(),
            'dt_start' => date($this->_dt_format, $this->getFirstOrderDate()),
            'dt_end' => date($this->_dt_format, time())
        ];
    }

    private function getFirstOrderDate()
    {
        $list = ItemOrder::getList(['filters' => [], 'sorters' => ['date ASC']], 1)->getItems();
        return strtotime($list[0]->date);
    }

    protected function afterDeleteItem()
    {
        ItemHistory::add("Заказы", "/adm/order");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(
            ['redirect' => $this->pathPrefix]
        );
        die();
    }
}
