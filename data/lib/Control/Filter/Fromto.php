<?php

namespace App\Control\Filter;

use App\Control\Element;
use App\Control\Filter;
use App\Query;
use App\Registry;
use App\Template;

class Fromto extends Element implements Filter
{
    protected $defaultFilter = '';
    protected $tpl = 'filter_fromto.tpl';
    protected $dbField = '';
    protected $getField = '';
    protected $filters = '';

    public function __construct($table, $field, $type = 'both', $title = 'Элементы', $subtitle = '', $filters = [])
    {
        $this->setField($field);
        $this->title = $title;
        $this->table = $table;
        $this->filters = $filters;
        $this->getBounds();
        $this->subtitle = $subtitle;
        $this->type = $type;
    }

    public function setBounds($from = null, $to = null)
    {
        $this->bounds = ['from' => $from, 'to' => $to];
    }

    public function getBounds()
    {
        if (empty($this->bounds)) {
            $db = Registry::get('db');
            $filters = '';

            if(!empty($this->filters)){
                $filters = sprintf('WHERE %s', implode(' AND ', $this->filters));
            }

            $rows = $db->query(sprintf('SELECT %s as `price` FROM `%s` %s', $this->dbField, $this->table, $filters), $db::QUERY_MODE_EXECUTE)->toArray();
            $rows = array_map(
                function ($row){
                    return (float)$row['price'] ?? 0;
                }, $rows
            );

            $rows = array_filter($rows);

            $data = [
                'min' => floor(min($rows ?:[0])),
                'max' => ceil(max($rows ?:[0])),
            ];

            $this->bounds = ['from' => (int)$data['min'], 'to' => (int)$data['max']];
        }
        return $this->bounds;

    }

    public function setField($field)
    {
        if (!empty($field)) {
            $this->dbField = $field;
            $this->getField = sprintf('fft_%s', $field);
        }
    }

    public function getActiveFilter()
    {
        $params = $this->getParams();
        return ['from' => (int)$params[$this->getField . '_from'], 'to' => (int)$params[$this->getField . '_to']];
    }

    public function getHTML()
    {
        $tpl = new Template();
        $tpl->assign('binded', $this->bindedParams);
        $tpl->assign('filter_title', $this->title);
        $tpl->assign('filter_subtitle', $this->subtitle);
        $tpl->assign('filter_name', $this->getField);
        $tpl->assign('active', $this->getActiveFilter());
        $tpl->assign('bounds', $this->bounds);
        $tpl->assign('filter_type', $this->type);
        return $tpl->fetch('filters/' . $this->tpl);
    }

    public function getParams()
    {
        $from = empty(Query::$get[$this->getField . '_from']) ? (isset($this->bounds['from']) ? $this->bounds['from'] : 0) : (int)Query::$get[$this->getField . '_from'];
        $to = empty(Query::$get[$this->getField . '_to']) ? (isset($this->bounds['to']) ? $this->bounds['to'] : 0) : (int)Query::$get[$this->getField . '_to'];
        return [$this->getField . '_from' => $from, $this->getField . '_to' => $to];
    }

    public function getFilterSQL()
    {
        $active = $this->getActiveFilter();
        $filters = [];
        if (!empty($active['from'])) {
            $filters[] = sprintf('`%s` >= %d', $this->dbField, $active['from']);
        }
        if (!empty($active['to'])) {
            $filters[] = sprintf('`%s` <= %d', $this->dbField, $active['to']);
        }
        return join(' AND ', $filters);
    }

    public function setDefaultFilter($type, $values = [])
    {
        if (empty(Query::$get[$this->getField . '_from'])) {
            Query::$get[$this->getField . '_from'] = empty($values['from']) ? '' : $values['from'];
        }
        if (empty(Query::$get[$this->getField . '_to'])) {
            Query::$get[$this->getField . '_to'] = empty($values['to']) ? '' : $values['to'];
        }
    }


}
