<?php

namespace App\Site\Controller;

use App\Item\Catalog;
use App\Query;
use App\Site\Controller;

class Product extends Controller
{
    public function isDispatchable($pathStr): false|int
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match('/^product\/.*$/', $pathStr);
    }

    public function run(): void
    {
        $success = false;
        $data = [];

        switch ($this->path[1]) {
            case 'variant':
                $item = new Catalog((int)Query::$post['product_id']);
                $attributes = json_decode(Query::$post['attributes'], true);

                if (!empty($item->id) && !empty($attributes["size"]) && !empty($attributes["height"])) {
                    $variants = $item->getVariantsByKeys(
                        ["size" => $attributes["size"], "height" => $attributes["height"]]
                    );
                    $variant = array_shift($variants);

                    if (!empty($variant["id"])) {
                        $data = ["variation_id" => $variant["id"]];
                        $success = true;
                    }
                }

                break;
        }

        $result = [
            'success' => $success,
            'data' => $data,
        ];
        echo json_encode($result);
        die();
    }
}
