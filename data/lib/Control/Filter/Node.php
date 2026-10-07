<?php

namespace App\Control\Filter;

use App\Control\Element;
use App\Control\Filter;
use App\Query;
use App\Structure;
use App\Template;
use App\Node as AppNode;

class Node extends Element implements Filter
{

    protected $defaultFilter = '';
    protected $tpl = 'filter_node.tpl';
    protected $dbField = '';
    protected $getField = '';
    protected $node = 0;
    public $list = array();
    public $tree = array();

    const TYPE_ALL = 'all';

    public function __construct($field, $title = 'Элементы', $node = 'catalog', $advanced = false)
    {
        $this->setField($field);
        $this->title = $title;
        $this->node = $node;
        $this->advanced = $advanced;
        $this->setItems();
    }

    protected function setItems()
    {
        if ($this->advanced) {
            $this->tree = AppNode::getListArray(['filters' => ['public=1', 'selection=1']])->getItems();
            $this->setList($this->tree);
        } else {
            $node = AppNode::getListArray(['filters' => ['public=1', "type='" . $this->node . "'"]])->getItems();
            $id = (!empty($node[0]['id'])) ? $node[0]['id'] : 0;
            $this->tree = Structure::get_instance()->get_tree($id);
            $this->setList($this->tree);
        }
    }

    protected function setList($list)
    {
        $ids = [];
        foreach ($list as $item) {
            $itemIds = array();
            if (!empty($item['childs'])) {
                $itemIds = $this->setList($item['childs']);
            }
            $itemIds[] = $item['id'];
            $this->list[$item['id']] = $itemIds;
            $ids = array_merge($ids, $itemIds);
        }
        return $ids;
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

    public function getActiveFilter()
    {
        if (!empty(Query::$post[$this->getField])) {
            if (!in_array(Query::$post[$this->getField], array_keys($this->list))) {
                return self::TYPE_ALL;
            }

            return Query::$post[$this->getField];
        }

        if (!isset(Query::$get[$this->getField])) {
            return $this->defaultFilter;
        } elseif (!in_array(Query::$get[$this->getField], array_keys($this->list))) {
            return self::TYPE_ALL;
        }
        return Query::$get[$this->getField];
    }

    public function getHTML()
    {
        $tpl = new Template();
        $filters = $this->tree;
        array_unshift($filters, array('title' => "Все", 'value' => self::TYPE_ALL));
        $tpl->assign('filters', $filters);
        $tpl->assign('binded', $this->getBindedParamsQueryString());
        $tpl->assign('active', $this->getActiveFilter());
        $tpl->assign('name', $this->getField);
        $tpl->assign('title', $this->title);
        return $tpl->fetch('filters/' . $this->tpl);
    }

    public function getFilterSQL()
    {
        $active = $this->getActiveFilter();
        if (empty($active) || $active == self::TYPE_ALL) {
            return '';
        }
        $ids = $this->list[$active];
        if (empty($ids)) {
            return '';
        }

        if ($this->advanced) {
            $filters = [];
            $node = new AppNode($ids[0]);
            $node->getParams();

            if ($node->selection && ($node->params["products"] || $node->params["categories"])) {
                if ($node->params["products"]) {
                    $filters["ids"] = "id IN (" . $node->params["products"] . ")";
                }
                if ($node->params["categories"]) {
                    $filters["nodes"] = "node IN (" . $node->params["categories"] . ")";
                }

                if ($filters["ids"] && $filters["nodes"]) {
                    $filters["sborpage"] = "(" . $filters["ids"] . " OR " . $filters["nodes"] . ")";
                    unset($filters["ids"]);
                    unset($filters["nodes"]);
                }
            }

            return $filters["sborpage"] ?: 1;
        } else {
            return sprintf("%s IN (%s)", $this->dbField, join(',', $ids));
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

}
