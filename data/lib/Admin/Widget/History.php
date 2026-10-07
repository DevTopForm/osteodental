<?php

namespace App\Admin\Widget;

use App\Item\History as ItemHistory;

class History extends Widget
{
    const ITEMS_CLASS = ItemHistory::class;

    protected function setTemplateData()
    {
        $this->tpl->assign('list', $this->getList());
        $this->tpl->assign('widget', $this->widget);
    }

    protected function getList()
    {
        return static::ITEMS_CLASS::getList(['filters' => [], 'sorters' => ['id DESC']], 40)->getItems();
    }
}