<?php

namespace App\Control\Filter;

use App\Control\Element;
use App\Control\Filter;

class Variant extends Element implements Filter
{
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function getFilterSQL()
    {
        $activeFiltersCount = 0;
        $ids = [];
        $flatArray = [];

        foreach ($this->filters ?: [] as $filter) {
            $filterIds = $filter->getFilterSQL();
            if ($filterIds !== "all") {
                $activeFiltersCount++;
                foreach ($filterIds as $itemId => $variants) {
                    foreach ($variants ?: [] as $variantId) {
                        $flatArray[] = $itemId . ':' . $variantId;
                    }
                }
            }
        }

        foreach (array_count_values($flatArray) as $id => $count) {
            if ($count === $activeFiltersCount) {
                $ids[] = explode(":", $id)[0];
            }
        }

        $ids = array_unique($ids);

        if (empty($ids)) {
            if ($activeFiltersCount) {
                return "0 = 1";
            } else {
                return "";
            }
        } else {
            return "id IN (" . implode(",", $ids) . ")";
        }
    }

    public function getHTML()
    {
        if (empty($this->filters)) {
            return '';
        }

        $string = "";
        foreach ($this->filters as $filter) {
            $string .= $filter->getHTML();
        }

        return $string;
    }
}