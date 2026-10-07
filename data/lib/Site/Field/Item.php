<?php

namespace App\Site\Field;

use App\Message;
use App\Model;

class Item extends Model
{

    protected $table = 'site_params_fields';
    protected $option_table = 'site_params_values';
    protected $defaultSorter = 'weight';
    protected $isCachable = true;

    public static $types = array(
        'text' => "TEXT NOT NULL",
        'textarea' => "TEXT NOT NULL",
        'checkbox' => "TINYINT(1) NOT NULL DEFAULT 0",
        'image' => "INT(11) NOT NULL DEFAULT 0",
        'date' => "DATETIME DEFAULT NULL",
        'integer' => "INT(11) NOT NULL DEFAULT 0",
        'smalltext' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'medtext' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'multiselect' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'multisel2area' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'multitext' => "TEXT NOT NULL",
        'select' => "INT(11) NOT NULL DEFAULT 0",
        'file' => "INT(11) NOT NULL DEFAULT 0",
        'multiimage' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'yapoint' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'multifile' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'alias' => "VARCHAR(255) NOT NULL DEFAULT ''",
        'hidden' => "INT(11) NOT NULL DEFAULT 0",
        'simplefile' => "INT(11) NOT NULL DEFAULT 0",
        'variant' => "INT(11) NOT NULL DEFAULT 0"
    );

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData()
    {
        if ($this->table == 'site_params_values') {
            $data = array(
                'name' => $this->name,
                'value' => '',
            );
        } else {
            $data = array(
                'name' => $this->name,
                'title' => $this->title,
                'field' => $this->field,
                'example' => empty($this->example) ? '' : $this->example,
                'editor' => empty($this->editor) ? 0 : 1,
                'format' => empty($this->format) ? '' : $this->format,
                'multi' => empty($this->multi) ? 0 : 1,
                'show' => 1,
                'required' => empty($this->required) ? 0 : 1,
                'weight' => empty($this->weight) ? 1000 : $this->weight,
                'options' => empty($this->options) ? 0 : 1,
                'table' => '',
                'sorter' => empty($this->sorter) ? 0 : $this->sorter,
                'advanced' => empty($this->advanced) ? 0 : 1,
                'main' => empty($this->main) ? 0 : 1
            );
        }
        return $data;
    }

    public function validate()
    {
        $valid = true;
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

    //действия после добавления объекта
    protected function insertAction()
    {
        try {
            if ($this->table != 'site_params_values') {
                $this->table = 'site_params_values';
                unset($this->id);
                $this->save();
            }
        } catch (\Exception $e) {
            pre($e->getMessage());
        }
    }
}

?>
