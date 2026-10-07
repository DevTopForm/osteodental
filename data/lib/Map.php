<?php

namespace App;

class Map
{
    private $items = array();

    public function get($id)
    {
        if (array_key_exists($id, $this->items)) {
            return $this->items[$id];
        }
        return null;
    }

    public function set($id, $item)
    {
        $this->items[$id] = $item;
    }

    public function delete($id)
    {
        if (array_key_exists($id, $this->items)) {
            unset($this->items[$id]);
        }
    }

    public static function getMap($key)
    {
        $key = 'items_' . $key;
        if (!Registry::isRegistered($key)) {
            Registry::set($key, new self());
        }
        return Registry::get($key);
    }

    public function isEmpty()
    {
        return empty($this->items);
    }
}