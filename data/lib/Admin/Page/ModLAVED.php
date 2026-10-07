<?php

namespace App\Admin\Page;

use App\Node\Item;
use App\Node\Type;
use App\Query;
use App\Utils;
use App\Item\History as ItemHistory;

class ModLAVED extends LAVED
{

    protected $action = 'module';

    protected function getStateRegexps()
    {
        return array(
            self::STATE_LIST => '/^list\/\d+$/i',
            self::STATE_ADD => '/^add\/\d+$/i',
            self::STATE_EDIT => '/^edit\/\d+\/\d+$/i',
            self::STATE_DELETE => '/^delete\/\d+\/\d+$/i',
        );
    }

    protected function executeRequestProcessing()
    {
        $this->module = new Type(@intval($this->parts[3]));
        if (empty($this->module->id)) {
            Utils::redirect($this->admPath);
        }
        parent::executeRequestProcessing();
    }

    protected function extractItemId()
    {
        return @intval($this->parts[4]);
    }

    protected function getItem()
    {
        return new Item($this->extractItemId());
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
    }

    protected function afterSaveItem()
    {
        ItemHistory::add("Модули", "/adm/module");
        Utils::redirect($this->pathPrefix . '/list/' . $this->module->id);
    }

    protected function afterDeleteItem()
    {
        ItemHistory::add("Модули", "/adm/module");
        Utils::redirect($this->pathPrefix . '/list/' . $this->module->id);
    }

    protected function parseStateList()
    {
        $tpl = $this->getItemsTpl();
        $items = $this->prepareList($this->getItemsList());
        $tpl->assign('module', $this->module);
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
        return array('type' => sprintf('type = "%s"', $this->module->type));
    }

    protected function parseStateEdit()
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->prepareEditItemHtml($this->item));
        $tpl->assign('module', $this->module);
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->item->errors);
        return $tpl->fetch($this->localTpl);
    }
}