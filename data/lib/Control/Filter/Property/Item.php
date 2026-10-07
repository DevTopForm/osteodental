<?php

namespace App\Control\Filter\Property;

use App\Control\Filter;
use App\Control\Filter\Item as FilterItem;

class Item extends FilterItem implements Filter
{

    protected function setItems($list, $key)
    {
        foreach ($list as $item) {
            if(
                !is_array($item)
                && !is_object($item)
            ){
                $item_a = [
                    'id' => $item,
                    'value' => $item,
                    'title' => $item,
                ];
            }elseif (!is_array($item)) {
                $item_a = $item->toArray();
            } else {
                $item_a = $item;
            }
            $this->list[$item_a['id']] = array('title' => $item_a['title'], 'value' => $item_a['id']);
        }
    }


    public function setField($field){
        if (!empty($field)){
            $this->dbField = sprintf('properties->>"$.%s"', $field);
            $this->getField = sprintf('fi_%s',$field);
        }
    }
}