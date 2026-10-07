<?php

namespace App\Cabinet\Page;

use App\Item;
use App\Node;
use App\Utils;

class Search extends LAVED
{
    protected string $localTpl = 'cabinet/search-resume.tpl';

    protected function defineState(): void
    {
        if ($this->user->role != 'employer') {
            Utils::redirect('/cabinet/denied');
        }
        parent::defineState();
    }

    protected function getStateRegexps(): array
    {
        return [
            self::STATE_LIST => '/^list$/i',
            self::STATE_VIEW => '/^view\/\d+$/i',
        ];
    }

    protected function getItem(): null
    {
        return null;
    }

    protected function getItemsList(): array
    {
        return [];
    }

    protected function getListFilters(): array
    {
        return [];
    }

    protected function getListSorters(): array
    {
        return [];
    }

    protected function parseStateView(): string
    {
        $this->rightpart = false;
        return parent::parseStateView();
    }

    protected function prepareViewItemHtml($item)
    {
        $item->updateViews($this->user);
        $item->favour = $this->user->isFavour($item->id, 'resume');
        if (!empty($item->experience)) {
            foreach ($item->experience as $key => $exp) {
                $item->experience[$key]['sphere'] = new Node($exp['sphere']);
            }
        }
        if (!empty($item->language['default'])) {
            foreach ($item->language['default'] as $key => $lng) {
                $item->language['default'][$key] = ['lng' => new Item($key, 'list'), 'level' => $lng];
            }
        }
        return $item;
    }

    protected function prepareList($list)
    {
        $items = $list->getItems();
        foreach ($items as $item) {
            $item->favour = $this->user->isFavour($item->id, 'resume');
        }
        $list->setItems($items);
        return $list;
    }
}