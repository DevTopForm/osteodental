<?php

namespace App\Item;

use App\Model;

class Favorite extends Model
{

    protected $table = 'favorites';
    protected $defaultSorter = 'title';
    protected $defaultOrder = 'ASC';

    public int|null $id;
    public string|null $title;
    public string|null $url;

    protected function getData(): array
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
        ];
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public static function add($title, $url): void
    {
        $existingItems = static::getList(["filters" => ["url = '$url'"], "sorters" => []])->getItems();
        if (empty($existingItems)) {
            $item = new static();
            $item->title = $title;
            $item->url = $url;
            if ($item->validate()) {
                $item->save();
            }
        }
    }

    public static function findAndDelete($url): void
    {
        $existingItems = static::getList(["filters" => ["url = '$url'"], "sorters" => []])->getItems();
        if (!empty($existingItems)) {
            foreach ($existingItems as $item) {
                $item->delete();
            }
        }
    }

    public function validate(): bool
    {
        $valid = true;

        $notEmptyFields = ["title", "url"];
        foreach ($notEmptyFields as $field) {
            if (empty($this->$field)) {
                $valid = false;
                break;
            }
        }

        return $valid;
    }

    public static function isFavorite($url): bool
    {
        $url = parse_url($url, PHP_URL_PATH);
        $existingItems = static::getList(["filters" => ["url = '$url'"], "sorters" => []])->getItems();
        return !empty($existingItems);
    }
}
