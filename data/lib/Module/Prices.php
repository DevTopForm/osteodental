<?php

namespace App\Module;

use App\Image;
use App\Node;
use App\Query;

class Prices extends Listing
{
    public static function prepareItem($item)
    {
        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        if(!empty($item->list) && !is_array($item->list)) {
            $item->list = unserialize($item->list);
        }

        return $item;
    }
}