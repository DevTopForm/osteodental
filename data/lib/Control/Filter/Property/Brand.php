<?php

namespace App\Control\Filter\Property;

use App\Control\Filter;
use App\Control\Filter\Property\Item as PropertyItem;

class Brand extends PropertyItem implements Filter
{
    protected $tpl = 'filter_brand.tpl';
}