<?php

class Item_Portfolio extends Model {

    protected $table = 'content_portfolio';
    protected $defaultSorter = 'sorter';
    protected $defaultOrder = 'ASC';
    protected $isCachable = true;

    protected function prepareData(){
        if(!empty($this->image) && !is_object($this->image) && !is_array($this->image)){
            $this->image = new Image($this->image);
        }

        if(empty($this->url)){
            $node = new Node($this->node);
            $this->url = $node->getUrl().'/'.$this->alias;
        }
    }

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