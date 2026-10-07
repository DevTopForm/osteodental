<?php

namespace App;

use App\Control\Pager;
use App\Control\Pager\Zero;

class RecordSet
{
    private $total = 0;
    private $items = array();
    private $pager;

    public function __construct()
    {
        $this->pager = new Zero();
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getPager()
    {
        return $this->pager;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function setPager(Pager $pager)
    {
        $this->pager = $pager;
    }

    public function setTotal($total)
    {
        $this->total = intval($total);
    }
}
