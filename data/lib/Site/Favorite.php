<?php

namespace App\Site;

use App\Cabinet\LoginManager;
use App\Item\Catalog\Favorite as ItemFavorite;

class Favorite extends Model
{

    protected static $instance = null;
    protected $sesskey = 'favorite';

    protected function getData()
    {
        $this->data = [];

        try {
            $user = LoginManager::getLoggedUser();
            $filters['user_id'] = sprintf('user_id = %s', $user->id);
        } catch (\Exception $e) {
            $filters['ip'] = sprintf('ip LIKE "%s"', $_SERVER['REMOTE_ADDR']);
        }

        $data = ItemFavorite::getList(
            [
                'filters' => $filters,
                'sorters' => [
                    'id DESC'
                ]
            ],
            NULL
        )->getItems();

        foreach ($data as $sessItem) {
            $this->data[$sessItem->product->id] = $sessItem;
        }

        return $this->data;
    }

    protected function saveData()
    {
        $items = [];

        try {
            $user = LoginManager::getLoggedUser();
            $filter['user_id'] = sprintf('user_id = %s', $user->id);
        } catch (\Exception $e) {
            $filter['ip'] = sprintf('ip LIKE "%s"', $_SERVER['REMOTE_ADDR']);
        }

        if (!empty($this->data)) {
            foreach ($this->data as $item) {
                $filter['product_id'] = $item->id;

                $element = ItemFavorite::getByKeys($filter);

                if (empty($element->id)) {
                    $element = new ItemFavorite();

                    if (!empty($user->id)) {
                        $element->user_id = $user->id;
                    } else {
                        $element->ip = $_SERVER['REMOTE_ADDR'];
                    }

                    $element->product = $item->product;
                    $element->save();
                }

                $items[] = $element;
            }
        }

        $this->data = $items;
    }

    public function addItem($item, $count = 1)
    {
        $key = $item->id;

        try {
            $user = LoginManager::getLoggedUser();
        } catch (\Exception $e) {
            $user = null;
        }

        $element = new ItemFavorite();

        if (!empty($user->id)) {
            $element->user_id = $user->id;
        } else {
            $element->ip = $_SERVER['REMOTE_ADDR'];
        }

        $element->product = $item;
        $element->save();

        $this->data[$key] = $element;
    }

    public function getTotal()
    {
        return [
            'count' => count($this->data),
            'items' => $this->data
        ];
    }

    public function removeItem($key)
    {
        $this->data[$key]->delete();
        unset($this->data[$key]);
    }
}
