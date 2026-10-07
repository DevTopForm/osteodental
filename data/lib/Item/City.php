<?php

namespace App\Item;

use App\Model;

class City extends Model
{

    protected $table = 'item_cities';
    protected $defaultSorter = 'city';
    protected $defaultOrder = 'ASC';
    protected $isCachable = false;

    protected function getData()
    {
        return [];
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function validate()
    {
        return true;
    }
}

?>