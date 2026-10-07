<?php

namespace App\Node;

use App\Message;
use App\Model;

class Group extends Model
{

    protected $table = 'nodes_groups';
    protected $defaultSorter = 'weight';

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData()
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'weight' => empty($this->weight) ? 0 : $this->weight,
        ];
    }

    public function validate()
    {
        $valid = true;

        if (empty($this->type)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо выбрать модуль', 'error');
        }

        if (empty($this->title)) {
            $valid = false;
            $this->errors[] = new Message('Заголовок группы', 'error');
        }

        return $valid;
    }
}

?>
