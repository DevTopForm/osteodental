<?php

namespace App\Item\Order;

use App\Message;
use App\Model;

class Status extends Model
{

    protected $table = 'order_status';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'aSC';

    protected function prepareData()
    {
    }

    protected function getData()
    {
        return [
            'title' => $this->title,
        ];
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->title)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Заголовок»', 'error');
        }
        return $valid;
    }


}
