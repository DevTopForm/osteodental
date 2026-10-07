<?php

namespace App\Item;

use App\Message;
use App\Model;
use App\Query;
use App\Utils;

class Widget extends Model
{

    protected $table = 'widget';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'ASC';
    protected $widgetsPath = '\\App\\Admin\\Widget\\';

    protected function prepareData()
    {
        $name = $this->widgetsPath . ucfirst(strtolower($this->name));

        if(class_exists($name)){
            $this->widget = new $name($this);
        }
    }

    protected function getData()
    {
        return [
            'title' => $this->title,
            'name' => $this->name,
            'icon' => $this->icon ?? '',
            'sorter' => $this->sorter ?? 0,
            'public' => $this->public ?? 0,
            'is_show' => $this->is_show ?? 0,
            'metric_id' => $this->metric_id,
            'metric_token' => $this->metric_token
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

        if (empty($this->name)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Сервисное имя»', 'error');
        }
        return $valid;
    }

    public function isShow(): bool
    {
        return !empty($this->is_show);
    }
}
