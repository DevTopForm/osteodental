<?php

namespace App\Item;

use App\Message;
use App\Model;

class Promocode extends Model
{
    protected $table = 'item_promocode';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'ASC';

    public $types = [
        1 => 'Одноразовый',
        2 => 'Многоразовый'
    ];

    protected function prepareData()
    {
        $this->products = empty($this->products) ? [] : explode(",", $this->products);
        $this->nodes = empty($this->nodes) ? [] : explode(",", $this->nodes);
    }

    protected function getData()
    {
        $data = [
            'title' => $this->title,
            'type' => empty($this->type) ? 0 : $this->type,
            'code' => $this->code,
            'sale' => empty($this->sale) ? 0 : $this->sale,
            'products' => empty($this->products) ? '' : implode(",", array_filter($this->products)),
            'nodes' => empty($this->nodes) ? '' : implode(",", array_filter($this->nodes)),
            'active' => empty($this->active) ? 0 : 1
        ];

        return $data;
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
            $this->errors[] = new Message('Необходимо заполнить поле «Наименование»', 'error');
        }

        if (empty($this->code)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Код»', 'error');
        }

        if (empty($this->sale)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо заполнить поле «Скидка %»', 'error');
        } elseif ($this->sale < 0 || $this->sale > 100) {
            $this->errors[] = new Message('Значение поля «Скидка %» должно быть между 0 и 100', 'error');
        }
        return $valid;
    }


    public static function codeExist($code, $id)
    {
        $item = self::getByKey('code', $code);

        if (!empty($item->id) && $item->id != $id) {
            return true;
        }

        return false;
    }

    public static function codeActive($code)
    {
        $data = [
            'code' => $code,
            'active' => 1
        ];

        $item = self::getByKeys($data);

        if (!empty($item->id)) {
            return true;
        }

        return false;
    }

    public static function getByCode($code)
    {
        $data = [
            'code' => $code,
            'active' => 1
        ];

        return self::getByKeys($data);
    }
}
