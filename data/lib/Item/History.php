<?php

namespace App\Item;

use App\Model;

class History extends Model
{

    protected $table = 'history';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'DESC';

    const MAX_COUNT = 40;

    public int $id;
    public string|null $title;
    public string|null $url;
    public string $date;

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
        if (!empty($existingItems)) {
            foreach ($existingItems as $existingItem) {
                $existingItem->delete();
            }
        }

        $item = new static();
        $item->title = $title;
        $item->url = $url;
        if ($item->validate()) {
            $item->save();
        }

        static::removeExtraRecords();
    }

    protected static function removeExtraRecords(): void
    {
        $items = static::getList(["filters" => [], "sorters" => ["id ASC"]])->getItems();

        if (!empty($items) && count($items) > self::MAX_COUNT) {
            for ($i = 0; $i < count($items) - self::MAX_COUNT; $i++) {
                $item = array_shift($items);
                $item->delete();
            }
        }
    }

    public function validate(): bool
    {
        $valid = true;

        $notEmptyFields = ["title", "url"];
        foreach ($notEmptyFields as $field) {
            if (empty($this->$field)){
                $valid = false;
                break;
            }
        }

        return $valid;
    }
}
