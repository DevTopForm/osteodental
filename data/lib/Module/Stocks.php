<?php

namespace App\Module;

use App\File;
use App\Form\Complex;
use App\Image;

class Stocks extends Listing
{

    public static function prepareItem($item)
    {
        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        return $item;
    }
}