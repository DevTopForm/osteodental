<?php

namespace App\Cabinet\Page;

use App\Node\Item;
use App\Query;

class Favorite extends LAVED
{

    protected string $localTpl = 'cabinet/favorite.tpl';
    protected mixed $item = null;
    protected array $errors = [];
    protected bool $withcounter = true;
    protected string $menuActive = 'favorite';

    const STATE_PAY = 'pay';
    const STATE_SUCCESS = 'success';
    const STATE_ERROR = 'error';
    const STATE_GETFILE = 'getfile';

    protected function setItemFields(): void
    {
        $this->item->title = strip_tags(Query::$post['title']);
        if (empty($this->item->id)) {
            $this->item->date = time();
            $this->item->user = $this->user;
        }
    }

    protected function getStateRegexps(): array
    {
        return [
            self::STATE_LIST => '/^list$/i'
        ];
    }

    protected function getListFilters(): array
    {
        if (!empty($this->user->favorite)) {
            return ['id IN (' . implode(',', $this->user->favorite) . ')'];
        } else {
            return [];
        }
    }

    protected function getListSorters(): array
    {
        return ['id DESC'];
    }

    protected function prepareList($list): null
    {
        if (!empty($this->user->favorite)) {
            return $list;
        } else {
            return null;
        }
    }

    protected function parseStateList(): string
    {
        $tpl = $this->getItemsTpl();
        Item::$itemsTable = 'content_catalog';
        $items = Item::getList($this->getParameters(), 20);
        if (!is_null($items)) {
            $tpl->assign('favorite', $items->getItems());
            $tpl->assign('total', $items->getTotal());
            $tpl->assign('pager', $items->getPager()->getHTML());
        }
        return $tpl->fetch($this->localTpl);
    }
}
