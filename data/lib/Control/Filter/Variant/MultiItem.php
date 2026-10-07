<?php

namespace App\Control\Filter\Variant;

use App\Control\Filter;
use App\Control\Filter\Property\Item;

class MultiItem extends Item implements Filter
{
    public function __construct($field, $title = 'Элементы', $items = [], $table)
    {
        $this->setField($field);
        $this->title = $title;
        $this->table = $table;
        $this->items = $items;
        $this->setItems($items, $field);
    }

    protected function setItems($list, $field)
    {
        $values = [];
        foreach ($list as $item) {
            if (empty($item->variants)) {
                continue;
            }

            foreach ($item->variants as $variant) {
                if (empty($variant[$field])) {
                    continue;
                }

                $values[] = $variant[$field];
            }
        }

        $values = array_unique(array_filter($values));

        foreach ($values as $value) {
            $this->list[$value] = [
                'title' => $value,
                'value' => $value,
            ];
        }
    }


    public function setField($field)
    {
        if (!empty($field)) {
            $this->dbField = $field;
            $this->getField = sprintf('fi_%s', $field);
        }
    }


    public function getFilterSQL()
    {
        $active = $this->getActiveFilter();
        if ($active == self::TYPE_ALL) {
            return 'all';
        }

        $ids = [];
        foreach ($this->items as $item) {
            if (!$item->public || empty($item->variants)) {
                continue;
            }

            foreach ($item->variants as $variant) {
                if (empty($variant[$this->dbField])) {
                    continue;
                }

                if (in_array($variant[$this->dbField], $active)) {
                    $ids[$item->id][$variant["id"]] = $variant["id"];
                }
            }
        }

        return $ids;
    }
}