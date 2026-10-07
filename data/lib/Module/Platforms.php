<?php

namespace App\Module;

use App\Image;

class Platforms extends Listing
{
    protected static function prepareItem($item)
    {
        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        if (!empty($item->image_white) && !is_object($item->image_white)) {
            $item->image_white = new Image($item->image_white);
        }

        return $item;
    }
}