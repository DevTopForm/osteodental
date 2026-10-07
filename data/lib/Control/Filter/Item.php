<?php

namespace App\Control\Filter;

use App\Control\Element;
use App\Control\Filter;
use App\Query;
use App\Registry;
use App\Template;

class Item extends Element implements Filter
{

    protected $defaultFilter = 'all';
    protected $tpl = 'filter_item.tpl';
    protected $dbField = '';
    protected $getField = '';
    protected $list = array();
    protected $variantProperty = false;
    protected $allValues = [];

    const TYPE_ALL = 'all';

    public function __construct($field, $title = 'Элементы', $items = array(), $key = 'title')
    {
        $this->setField($field);
        $this->title = $title;
        $this->setItems($items, $key);
    }

    protected function setItems($list, $key)
    {
        foreach ($list as $item) {
            if (!is_array($item)) {
                $item_a = $item->toArray();
            } else {
                $item_a = $item;
            }
            $this->list[$item_a['id']] = array('title' => $item_a[$key], 'value' => $item_a['id']);
        }
    }

    public function setDefault($filter)
    {
        $this->defaultFilter = $filter;
    }

    public function setField($field)
    {
        if (!empty($field)) {
            $this->dbField = $field;
            $this->getField = sprintf('fi_%s', $field);
        }
    }

    public function getName()
    {
        return $this->getField;
    }

    public function getActiveFilter()
    {
        if (!isset(Query::$get[$this->getField])) {
            return $this->defaultFilter;
        } elseif (is_array(Query::$get[$this->getField])) {
        } elseif (!in_array(Query::$get[$this->getField], array_keys($this->list))) {
            return self::TYPE_ALL;
        }

        foreach ($this->list as &$item) {
            if (array_search($item['value'], Query::$get[$this->getField]) !== false) {
                $item['active'] = true;
            }
        }
        unset($item);
        return Query::$get[$this->getField];
    }

    public function getHTML()
    {
        if (empty($this->list)) {
            return '';
        }

        $tpl = new Template();
        $active = $this->getActiveFilter();
        $filters = $this->list;
        //array_unshift($filters,array('title' => "Все", 'value' => self::TYPE_ALL));
        $tpl->assign('filters', $filters);
        $tpl->assign('binded', $this->getBindedParamsQueryString());
        $tpl->assign('active', $active);
        $tpl->assign('name', $this->getField);
        $tpl->assign('title', $this->title);
        return $tpl->fetch('filters/' . $this->tpl);
    }

    public function getFilterSQL()
    {
        $active = $this->getActiveFilter();
        if ($active == self::TYPE_ALL) {
            return '';
        }

        if (is_array($active)) {
            return sprintf("%s IN('%s')", $this->dbField, implode("','", $active));
        } else {
            return sprintf("%s = '%s'", $this->dbField, $active);
        }
    }

    public function getParams()
    {
        $active = $this->getActiveFilter();
        if (empty($active)) {
            return array();
        }
        return array($this->getField => $active);
    }

    public function variantProperty()
    {
        $this->variantProperty = true;
    }

    public function isVariantProperty()
    {
        return $this->variantProperty;
    }

    public function getAllValues($table, $node, $options)
    {
        $db = Registry::get('db');
        if (empty($options)) {
            //$sql = sprintf("SELECT DISTINCT %s FROM %s WHERE LENGTH(%s) > 0 AND node = '%s'", $this->dbField, $table, $this->dbField, $node);
            $sql = sprintf("SELECT DISTINCT %s FROM %s WHERE LENGTH(%s) > 0", $this->dbField, $table, $this->dbField);
            $list = $db->query($sql, [])->toArray();
            foreach ($list as $item) {
                $this->list[$item[$this->dbField]] = [
                    'title' => $this->title,
                    'value' => $item[$this->dbField]
                ];
            }
        } else {
            foreach ($options as $item) {
                $this->list[$item['id']] = [
                    'title' => $item['title'],
                    'value' => $item['value']
                ];
            }
        }

        if (empty($this->list)) {
            return false;
        }

        return true;
    }
}