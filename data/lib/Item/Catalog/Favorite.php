<?php

namespace App\Item\Catalog;

use App\Item\Catalog;
use App\Model;

class Favorite extends Model
{
    protected $table = 'item_favorites';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'ASC';

    protected function prepareData()
    {

        if(!empty($this->product_id)){
            $this->product = Catalog::getByKey('id', $this->product_id);
        }
    }

    protected function getData()
    {
        return [
            'user_id' => $this->user_id ?: null,
            'ip' => $this->ip ?: null,
            'product_id' => $this->product->id ?? 0
        ];
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }
}