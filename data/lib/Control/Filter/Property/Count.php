<?php

namespace App\Control\Filter\Property;

use App\Control\Filter;
use App\Query;
use App\Template;

class Count extends Item implements Filter
{

    const DEFAULT_TEMPLATE = 'filter_count.tpl';

    protected function setItems($list, $key)
    {
        $this->list[1] = [
            'title' => 'В наличии',
            'value' => 1
        ];
    }

    public function getFilterSQL()
    {
        $active = $this->getActiveFilter();

        if(!empty($active)){
            return sprintf("%s > 0", $this->dbField);
        }

        return  '';
    }

    public function getActiveFilter()
    {
        return !empty(Query::$get[$this->getField]);
    }
}