<?php

namespace App\Item;

use App\Model;

class Log extends Model
{
    public string $title;
    public string $class;
    public int $active;
    public object $object;

    protected $table = 'logs';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'ASC';
    protected string $logsPath = '\\App\\Admin\\Log\\';

    protected function prepareData()
    {
        $name = $this->logsPath . $this->class;

        if (class_exists($name)) {
            $this->object = new $name($this);
        }
    }

    protected function getData()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'class' => $this->class,
            'active' => $this->active,
        ];
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }
}