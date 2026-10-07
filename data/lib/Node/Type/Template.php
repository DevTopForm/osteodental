<?php

namespace App\Node\Type;

use App\Message;
use App\Model;

class Template extends Model
{

    protected $table = 'nodes_types_templates';
    protected $isCachable = true;

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData()
    {
        return array(
            'title' => $this->title,
            'type' => $this->type,
            'file' => $this->file,
            'in_block' => $this->in_block ? 1 : 0
        );
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->title)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить название шаблона', 'error');
        }
        if (empty($this->file)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить имя файла', 'error');
        }
        if (empty($this->type)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо выбрать тип', 'error');
        }
        return $valid;
    }

}

?>
