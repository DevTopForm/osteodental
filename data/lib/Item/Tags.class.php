<?php

class Item_Tags extends Model {

    protected $table = 'content_tags';
    protected $defaultSorter = 'sorter';
    protected $defaultOrder = 'ASC';
    protected $isCachable = true;

    protected function getData(){
        $data = array();
        return $data;
    }

    public static function getVar($name){
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function validate() {
        $valid = true;
        return $valid;
    }
}

?>