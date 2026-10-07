<?php

namespace App\Control\Filter\Property;

use App\Control\Filter;
use App\Control\Filter\Property\MultiItem as PropertyItem;

class Tag extends PropertyItem implements Filter
{
    protected $tpl = 'filter_tag.tpl';

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

            if (!empty($item_a["image"])) {
                $this->list[$item_a['id']]["image"] = $item_a["image"];
            }
        }
    }
}