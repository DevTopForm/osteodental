<?php

namespace App\Node;

use App\Message;
use App\Model;

class Template extends Model
{

    protected $table = 'nodes_templates';
    protected $defaultSorter = 'title';
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
            'file' => $this->file,
            'scheme_file' => $this->scheme_file,
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
        if (empty($this->scheme_file)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить имя файла схемы', 'error');
        }
        return $valid;
    }

}

?>
