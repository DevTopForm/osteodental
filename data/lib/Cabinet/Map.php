<?php

namespace App\Cabinet;

class Map
{
    private array $items = [];

    public function get($id)
    {
        if (array_key_exists($id, $this->items)) {
            return $this->items[$id];
        }
        return null;
    }

    public function set($id, $item): void
    {
        $this->items[$id] = $item;
    }

    public function delete($id): void
    {
        if (array_key_exists($id, $this->items)) {
            unset($this->items[$id]);
        }
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }
}