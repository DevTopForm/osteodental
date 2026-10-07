<?php

namespace App;

use App\Control\Filter;
use App\Control\Pager;
use App\Control\Sorter;
use Laminas\Db\Sql\Expression;

class Searcher
{
    protected $table = '';
    protected $perPage = 25;

    protected $select;
    protected $countSelect;
    protected $db;
    protected $total = 0;
    protected $columns = array();
    protected $filters = array();
    protected $sorters = array();
    protected $noPager = false;

    public function __construct()
    {
        $this->db = Registry::get('db');
    }

    public function search()
    {
        if (empty($this->table)) {
            throw new \Exception('Undefined table');
        }

        $rs = new RecordSet();
        $this->prepareSelectObjects();
        $this->applyFilters();

        if ($this->noPager) {
            $items = $this->doSearch();
            $rs->setItems($items);
            $rs->setTotal(count($items));
        } else {
            $this->getTotal();
            $rs->setTotal($this->total);
            $this->preparePager($rs);
            if (!empty($this->total)) {
                $rs->setItems($this->doSearch());
            }
        }
        return $rs;
    }

    public function setTable($table)
    {
        $this->table = $table;
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;
    }

    public function noPager()
    {
        $this->noPager = true;
    }

    public function setPerPage($count)
    {
        $this->perPage = intval($count);
        if ($this->perPage <= 0) {
            $this->perPage = 25;
        }
    }

    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    public function addSorters(array $sorters)
    {
        foreach ($sorters as $sorter) {
            $this->addSorter($sorter);
        }
    }

    public function addFilter($filter)
    {
        if (is_string($filter)) {
            $this->filters[] = $filter;
        }
        if (is_a($filter, Filter::class)) {
            $this->filters[] = $filter->getFilterSQL();
        }
    }

    public function addSorter($sorter)
    {
        if (is_string($sorter)) {
            $this->sorters[] = $sorter;
        }
        if (is_a($sorter, Sorter::class)) {
            $this->sorters[] = $sorter->getSorterSQL();
        }
    }

    public function applySearchParameters($parameters)
    {
        if (!is_array($parameters)) {
            return;
        }
        if (!empty($parameters['filters']) && is_array($parameters['filters'])) {
            $this->addFilters($parameters['filters']);
        }
        if (!empty($parameters['sorters']) && is_array($parameters['sorters'])) {
            $this->addSorters($parameters['sorters']);
        }
    }

    protected function prepareSelectObjects()
    {
        $this->select = $this->db->sql->select();
        if (empty($this->columns)) {
            $this->select->from($this->table);
        } else {
            $this->select->from($this->table, $this->columns);
        }

        $this->countSelect = $this->db->sql->select();
        $this->countSelect->from(
            $this->table,
            array('total' => 'COUNT(*)')
        );
    }

    protected function applyFilters()
    {
        foreach ($this->filters as $filter) {
            if (empty($filter)) {
                continue;
            }
            $this->countSelect->where($filter);
            $this->select->where($filter);
        }
    }

    protected function applySorters()
    {
        foreach ($this->sorters as $sorter) {
            if (empty($sorter)) {
                continue;
            }
            $this->select->order(new Expression($sorter));
        }
    }

    protected function preparePager($rs)
    {
        if ($this->noPager) {
            return;
        }
        if ($this->total < $this->perPage()) {
            return;
        }
        $pager = new Pager();
        $pager->init($this->total, '', $this->perPage());
        $rs->setPager($pager);
        $this->select->limit($pager->getPerPage());
        $this->select->offset($pager->getFrom() - 1);
    }

    protected function perPage()
    {
        return $this->perPage;
    }

    protected function getTotal()
    {
        //$total = $this->db->fetchRow($this->countSelect->__toString());
        //$this->total = $total['total'];
        $this->total = $this->db->query($this->db->sql->buildSqlString($this->countSelect))->execute()->count();
    }

    protected function doSearch()
    {
        $this->applySorters();

        $sql = $this->db->sql->buildSqlString($this->select);
        $sql = explode('ORDER BY', $sql);

        if(!empty($sql[1])){
            $sql[1] = str_replace('`', '', $sql[1]);
        }

        $sql = implode('ORDER BY', $sql);

        return $this->db->query($sql, $this->db::QUERY_MODE_EXECUTE)->toArray();
    }
}
