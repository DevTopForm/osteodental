<?php
namespace App\Node\Field;

use App\Model;

class Value extends Model
{
    protected $table = 'nodes_fields_value';
    protected $defaultSorter = 'id';

    public static function getVar($name){
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }
}