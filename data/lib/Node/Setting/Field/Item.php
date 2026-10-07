<?php

namespace App\Node\Setting\Field;

use App\Message;
use App\Model;
use App\Node\Field\Item as NodeFieldItem;

class Item extends Model
{

    protected $table = 'nodes_params_fields';
    protected $defaultSorter = 'weight';
    protected $isCachable = true;

    protected function prepareData()
    {
        if (!empty($this->table_filter)) {
            $this->table_filter = unserialize($this->table_filter);
        } else {
            $this->table_filter = array();
        }
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData()
    {
        $data = array(
            'type' => $this->type,
            'name' => $this->name,
            'title' => $this->title,
            'field' => $this->field,
            'example' => empty($this->example) ? '' : $this->example,
            'editor' => empty($this->editor) ? 0 : 1,
            'format' => empty($this->format) ? '' : $this->format,
            'required' => empty($this->required) ? 0 : 1,
            'weight' => empty($this->weight) ? 0 : $this->weight,
            'table_data' => empty($this->table_data) ? '' : $this->table_data,
            'table_filter' => serialize($this->table_filter),
            'prepare' => empty($this->prepare) ? '' : $this->prepare,
            'local' => empty($this->local) ? 0 : 1,
            'edit_in_node' => empty($this->edit_in_node) ? 0 : 1,
        );
        return $data;
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->type)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо указаыть тип раздела', 'error');
        }
        if (empty($this->name)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле "Имя в таблице"', 'error');
        }
        if (empty($this->field)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо выбрать тип поля', 'error');
        }
        if (!array_key_exists($this->field, NodeFieldItem::$types)) {
            $valid = false;
            $this->errors[] = new Message('Указан недопустимый тип поля', 'error');
        }
        return $valid;
    }
}

?>
