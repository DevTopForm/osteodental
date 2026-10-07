<?php

namespace App\Control\Filter\Property;

use App\Control\Filter;
use App\Registry;

class MultiItem extends Item implements Filter
{
    public function __construct($field, $title = 'Элементы', $items = [], $table, $key = 'title')
    {
        $this->setField($field);
        $this->title = $title;
        $this->table = $table;
        $this->setItems($items, $key);
    }

    protected function setItems($list, $key)
    {
        foreach ($list as $item) {
            $this->list[$item["title"]] = [
                'title' => $item["title"],
                'value' => $item["value"],
            ];
        }
    }


    public function setField($field)
    {
        if (!empty($field)) {
            $this->dbField = sprintf('properties->>"$.%s"', $field);
            $this->getField = sprintf('fi_%s', $field);
        }
    }


    public function getFilterSQL()
    {
        $active = $this->getActiveFilter();
        if ($active == self::TYPE_ALL) {
            return '';
        }
        $db = Registry::get('db');
        $list = $db->query(sprintf('SELECT `id`, %s FROM `%s` WHERE `public` = ?', $this->dbField, $this->table), [1]
        )->toArray();
        $ids = [];
        foreach ($list as $item) {
            if (empty($item[$this->dbField])) {
                continue;
            }
            $values = explode(",", $item[$this->dbField]);
            if (count(array_intersect($active, $values))) {
                $ids[] = $item['id'];
            }
        }
        return empty($ids) ? 'FALSE' : sprintf("id IN (%s)", join(',', $ids));
    }
}