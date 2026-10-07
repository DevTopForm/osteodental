<?php

namespace App\Site;

use App\Image;
use App\Item\Catalog;
use App\Item\Promocode;

class Basket extends Model
{
    protected $sesskey = 'basket';
    protected static $instance = null;

    public function getTotal()
    {
        $data = ['count' => 0, 'summ' => 0];
        foreach ($this->data as $item) {
            $data['count'] += $item->count;

            $data['summ'] += $item->count * $item->price;
        }

        $data['suff'] = $this->getSuffix($data['count']);

        return $data;
    }

    protected function getData()
    {
        $this->data = [];
        $promocode = static::getActivePromo();
        if (!empty($promocode->id)) {
            $fields = ['products', 'nodes'];

            foreach ($fields as $field) {
                if (!empty($promocode->$field && !is_array($promocode->$field))) {
                    $promocode->$field = explode(',', $promocode->$field);
                } elseif (empty($promocode->$field)) {
                    $promocode->$field = [];
                }
            }
        }

        if (!empty($_SESSION[$this->sesskey])) {
            $data = $_SESSION[$this->sesskey];
            foreach ($data as $sessItem) {
                $itemObj = new Catalog($sessItem['id']);
                if (!empty($itemObj->id)) {
                    if (!empty($sessItem['variant']) && !is_array($sessItem['variant'])) {
                        $sessItem['variant'] = $itemObj->getVariant($sessItem['variant']);
                    }

                    if (!empty($sessItem['variant']["id"])) {
                        $key = $sessItem['id'] . '.' . $sessItem['variant']["id"];
                    } else {
                        $key = $sessItem['id'];
                    }

                    $this->data[$key] = $itemObj;
                    $this->data[$key]->variant = $sessItem['variant'];
                    $this->data[$key]->count = $sessItem['count'];

                    if (!empty($itemObj->image) && !is_object($itemObj->image)) {
                        $this->data[$key]->image = new Image($itemObj->image);
                    }

                    if (!empty($promocode->id)) {
                        if (in_array($itemObj->id, $promocode->products) || in_array(
                                $itemObj->node->id,
                                $promocode->nodes
                            )) {
                            $this->data[$key]->old_price = $itemObj->price;
                            $this->data[$key]->price = round($itemObj->price - (($itemObj->price * $promocode->sale) / 100), 0);
                        }
                    }

                    $this->data[$key]->summ = $this->data[$key]->count * $itemObj->price;
                }
            }
        }
        return $this->data;
    }

    protected function saveData()
    {
        $data = [];
        if (!empty($this->data)) {
            foreach ($this->data as $item) {
                $key = $this->getKeyForArray($item, $item->variant);
                $data[$key] = [
                    'id' => $item->id,
                    'count' => $item->count,
                    'variant' => (!empty($item->variant["id"]) ? $item->variant["id"] : 0),
                ];
            }
        }

        $_SESSION[$this->sesskey] = $data;
    }

    public function addItem($item, $count = 1, $variant = false): void
    {
        $key = $this->getKeyForArray($item, $variant);
        $item->variant = $variant;

        if (!empty($this->data[$key])) {
            $this->data[$key]->count += $count;
            $this->data[$key]->summ = $this->data[$key]->count * $this->data[$key]->price;
        } else {
            $this->data[$key] = $item;
            $this->data[$key]->count = $count;
        }

        $this->saveData();
    }

    public function isAdded($item, $variant = false): bool
    {
        $key = $this->getKeyForArray($item, $variant);
        return !empty($this->data[$key]);
    }

    public function getKeyForArray($item, $variant = false): string
    {
        if (empty($variant["id"])) {
            $key = $item->id;
        } else {
            $key = $item->id . '.' . $variant["id"];
        }

        return $key;
    }

    public function getItem($key)
    {
        return $this->data[$key];
    }

    public function setCount($key, $count)
    {
        if (empty($count)) {
            $this->removeItem($key);
        } elseif (!empty($this->data[$key])) {
            $this->data[$key]->count = $count;

            $this->data[$key]->summ = $this->data[$key]->count * $this->data[$key]->price;

            $this->saveData();
        }
    }

    public function getBasketData()
    {
        $this->getData();
    }

    public function getPrices(): array
    {
        $orderPrice = 0;
        $discountAmount = 0;

        $items = $this->getItems();
        foreach ($items as $item) {
            $orderPrice += ($item->old_price ?: $item->price) * $item->count;
            if (!empty($item->price) && !empty($item->old_price) && ($item->price != $item->old_price)) {
                $sale = $item->old_price - $item->price;
                $discountAmount += $sale;
            }
        }

        $totalPrice = $orderPrice - $discountAmount;

        return [
            "orderPrice" => $orderPrice,
            "discountAmount" => $discountAmount,
            "totalPrice" => $totalPrice,
        ];
    }

    public static function getActivePromo(): Promocode|null
    {
        if (!empty($_SESSION['promocode'])) {
            $promocode = Promocode::getByCode($_SESSION['promocode']);

            if (!empty($promocode->id)) {
                return $promocode;
            }
        }

        return null;
    }
}