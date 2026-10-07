<?php

namespace App\Admin;

use App\Message;
use App\Model;

class Action extends Model
{

    protected $table = 'admin_action';
    protected $isCachable = false;

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function getData()
    {
        return array(
            'title' => empty($this->title) ? '' : $this->title,
            'action' => $this->action,
            'class' => empty($this->class) ? '' : $this->class,
            'link' => empty($this->link) ? '' : $this->link,
            'menu' => empty($this->menu) ? 0 : 1,
            'info' => empty($this->info) ? 0 : 1,
            'icon' => empty($this->icon) ? 'others.svg' : $this->icon,
            'access' => empty($this->access) ? 0 : 1,
            'parent' => empty($this->parent) ? 0 : $this->parent,
        );
    }

    public function validate()
    {
        $valid = true;
        if (empty($this->action)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле "Сервисное имя"', 'error');
        }
        return $valid;
    }

    public static function getTree()
    {
        $array = static::getList()->getItems();
        $list = [];

        foreach ($array as $item) {
            $item->childs = [];
            $list[$item->id] = $item;
        }
        return static::prepareTree($list);
    }

    protected static function prepareTree($list)
    {
        $tree = [];

        foreach ($list as $item) {
            $current = &$list[$item->id];
            if (empty($item->parent)) {
                $tree[$item->id] = &$current;
            } else {
                $list[$item->parent]->childs[$item->id] = &$current;
            }
        }
        return $tree;
    }

}

?>
