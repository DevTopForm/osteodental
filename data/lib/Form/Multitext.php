<?php

namespace App\Form;

use App\Query;

class Multitext extends Text
{

    protected $class = "text";
    protected $values = array();


    public function getInsertValue()
    {
        return serialize($this->values);
    }

    public function setValue($value)
    {
        if (!empty($value)) {
            $this->value = $value;
            $this->values = unserialize($this->value);
        }
    }

    public function getSpecValue()
    {
        return $this->values;
    }

    public function setQueryValue()
    {
        if (!empty(Query::$post[$this->name])) {
            $values = array();
            foreach (Query::$post[$this->name] as $id => $data) {
                if (!empty($data)) {
                    $values[$id] = ["id" => $id, "value" => $data];
                }
            }
            $this->values = $values;
        }
    }
}
