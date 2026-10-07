<?php
/*
LAVED - List/Add/View/Edit/Delete
Страница реализует общую логику обработки и отображения
простых объектов-активных записей, когда работа в адиминистративном
интерфейсе представляет из себя просмотр списка таких объектов,
создания новых, редактирования и удаления.

А это очень распространенная задача. Пример - список новостей.
*/

namespace App\Admin\Page;

use App\Node\Item;
use App\Query;
use App\Utils;
use App\Node as AppNode;

class NodeLAVED extends LAVED
{

    const STATE_PUBLIC = 'public';

    protected $action = 'node';

    protected function getStateRegexps()
    {
        return array(
            self::STATE_LIST => '/^list\/\d+$/i',
            self::STATE_ADD => '/^add\/\d+$/i',
            self::STATE_EDIT => '/^edit\/\d+$/i',
            self::STATE_DELETE => '/^delete\/\d+$/i',
            self::STATE_PUBLIC => '/^public\/\d+$/i',
        );
    }

    protected function getItem()
    {
        return new Item($this->prepareItemId($this->extractItemId()));
    }

    protected function prepareItemId($itemId)
    {
        if ($this->state == self::STATE_ADD) {
            return 0;
        } else {
            return $itemId;
        }
    }

    protected function editItem()
    {
        $this->item = $this->getItem();
        if ($this->state == self::STATE_ADD) {
            $this->item->node = $this->extractItemId();
        }
        if (empty(Query::$post['save'])) {
            return;
        }
        $this->setItemFields();
        if ($this->item->validate()) {
            $this->item->save();
            $this->afterSaveItem();
        }
    }

    protected function afterSaveItem()
    {
        Utils::redirect($this->pathPrefix . '/list/' . $this->item->node);
    }

    protected function afterDeleteItem()
    {
        Utils::redirect($this->pathPrefix . '/list/' . $this->item->node);
    }

    protected function parseStateList()
    {
        $tpl = $this->getItemsTpl();
        $this->node = new AppNode($this->extractItemId());
        if (empty($this->node->id)) {
            Utils::redirect($this->admPath);
        }
        $items = $this->prepareList($this->getItemsList());
        $tpl->assign('node', $this->node);
        if (!is_null($items)) {
            $tpl->assign('list', $items->getItems());
            $tpl->assign('total', $items->getTotal());
            $tpl->assign('filters', $this->getFiltersHtml());
            $items->getPager()->bindWith($this->filters);
            $tpl->assign('pager', $items->getPager()->getHTML(true));
            $tpl->assign('perpage', $items->getPager()->getPerPage());
        }
        $tpl->assign('data', $this->getSpecialListData());
        return $tpl->fetch($this->localTpl);
    }

    protected function getListFilters()
    {
        return array('node' => sprintf('node = %d', $this->node->id));
    }

    protected function getListSorters()
    {
        return array();
    }

    protected function parseStateAdd()
    {
        return $this->parseStateEdit();
    }

    protected function parseStateEdit()
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->prepareEditItemHtml($this->item));
        $tpl->assign('node', $this->item->node);
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->item->errors);
        return $tpl->fetch($this->localTpl);
    }

    protected function getSpecialEditData()
    {
        return array();
    }

    protected function prepareViewItemHtml($item)
    {
        return $item;
    }

    protected function prepareEditItemHtml($item)
    {
        return $item;
    }
}