<?php

namespace App\Node\Field;

use App\Message;
use App\Form\Field as AppFormField;
use App\Node\Field;

class Complex extends Item
{
    protected $table = 'nodes_fields_complex';

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function prepareData()
    {
        $this->form_field = AppFormField::factory($this);
        $this->node_field = new Field($this);
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->fid)) {
            $valid = false;
            $this->errors[] = new Message('Потеряно родительское поле', 'error');
        }
        if (empty($this->name)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле "Имя в таблице"', 'error');
        }
        if (empty($this->field)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо выбрать тип поля', 'error');
        }
        if (!array_key_exists($this->field, static::$types)) {
            $valid = false;
            $this->errors[] = new Message('Указан недопустимый тип поля', 'error');
        }
        return $valid;
    }

    protected function getData(): array
    {
        $data = parent::getData();
        $data["fid"] = $this->fid;
        return $data;
    }
}