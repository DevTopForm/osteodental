<?php

namespace App\Cabinet\Page;

class Sales extends LAVED
{
    protected string $localTpl = 'cabinet/sales.tpl';
    protected mixed $item = null;
    protected array $errors = [];
    protected bool $withcounter = true;

    protected function defineState(): void
    {
        $this->state = self::STATE_LIST;
    }

    protected function getItemsList($archive = 0): array
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

    protected function getSpecialEditData(): array
    {
        return [];
    }

    protected function prepareViewItemHtml($item)
    {
        return $item;
    }

    protected function prepareList($list)
    {
        return $list;
    }
}