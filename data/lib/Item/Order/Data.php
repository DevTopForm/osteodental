<?php

namespace App\Item\Order;

use App\Image;
use App\Message;
use App\Model;

class Data extends Model
{

    protected $table = 'order_shop_data';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'DESC';

    protected function prepareData()
    {
        if (!empty($this->image)) {
            $this->image = new Image($this->image);
        }

        try {
            $this->item = $this->itemType::getByKey('id', $this->itemId);
        } catch (\Throwable $e) {
            $this->item = null;
        }
    }

    protected function getData()
    {
        $data = [
            'order' => empty($this->order) ? 0 : $this->order,
            'title' => empty($this->title) ? '' : $this->title,
            'url' => empty($this->url) ? '' : $this->url,
            'image' => empty($this->image->id) ? 0 : $this->image->id,
            'price' => empty($this->price) ? 0 : $this->price,
            'count' => empty($this->count) ? 0 : $this->count,
            'summ' => empty($this->summ) ? 0 : $this->summ,
            'itemId' => empty($this->itemId) ? 0 : $this->itemId,
            'itemVariant' => empty($this->itemVariant) ? null : $this->itemVariant,
            'itemType' => empty($this->itemType) ? '' : $this->itemType,
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
        if (empty($this->order)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо выбрать заказ', 'error');
        }
        if (empty($this->itemId)) {
            $valid = false;
            $this->errors[] = new Message('Необходимо указать товар', 'error');
        }
        return $valid;
    }
}

?>
