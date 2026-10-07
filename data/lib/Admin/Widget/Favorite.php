<?php

namespace App\Admin\Widget;

use App\Item\Favorite as ItemFavorite;

class Favorite extends Widget
{
    const ITEMS_CLASS = ItemFavorite::class;

    protected function setTemplateData()
    {
        $this->tpl->assign('list', $this->getList());
        $this->tpl->assign('widget', $this->widget);
    }

    protected function getList()
    {
        return static::ITEMS_CLASS::getList(['filters' => [], 'sorters' => ['title ASC']])->getItems();
    }
}