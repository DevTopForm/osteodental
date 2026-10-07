<?php

namespace App\Image;

use App\Message;
use App\Model;

class Size extends Model
{

    protected $table = 'image_size';

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData()
    {
        return array(
            'type' => $this->type,
            'title' => $this->title,
            'name' => $this->name,
            'width' => empty($this->width) ? 0 : $this->width,
            'height' => empty($this->height) ? 0 : $this->height,
            'watermark' => empty($this->watermark) ? 0 : 1,
        );
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->type)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо указать тип модуля', 'error');
        }
        if (empty($this->title)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить название типа', 'error');
        }
        if (empty($this->name)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить сервисное имя тип', 'error');
        }
        return $valid;
    }

}

?>
