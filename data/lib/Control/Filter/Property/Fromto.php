<?php

namespace App\Control\Filter\Property;

use App\Control\Filter;
use App\Control\Filter\Fromto as FilterFromto;
use App\Query;

class Fromto extends FilterFromto implements Filter
{
    public function setField($field)
    {
        if (!empty($field)) {
            $this->dbField = sprintf('properties->>"$.%s"', $field);
            $this->getField = sprintf('fft_%s', $field);
        }
    }

    public function getFilterSQL()
    {
        $active = $this->getActiveFilter();
        $filters = [];
        if (!empty($active['from'])) {
            $filters[] = sprintf('%s >= %d', $this->dbField, $active['from']);
        }
        if (!empty($active['to'])) {
            $filters[] = sprintf('%s <= %d', $this->dbField, $active['to']);
        }
        return join(' AND ', $filters);
    }

    public function getParams()
    {
        $res = [];

        $from = (int)Query::$get[$this->getField . '_from'];
        $to = (int)Query::$get[$this->getField . '_to'];

        if ($from) {
            $res[$this->getField . '_from'] = $from;
        }

        if ($to) {
            $res[$this->getField . '_to'] = $to;
        }

        return $res;
    }

    public function getBounds()
    {
        parent::getBounds();

        if (empty($this->bounds["from"]) && !empty($this->bounds["to"])) {
            $this->bounds["from"] = $this->bounds["to"];
        } elseif (!empty($this->bounds["from"]) && empty($this->bounds["to"])) {
            $this->bounds["to"] = $this->bounds["from"];
        }

        return $this->bounds;
    }

    public function getHTML(): string
    {
        if ($this->bounds["from"] === $this->bounds["to"]) {
            return "";
        }

        return parent::getHTML();
    }
}
