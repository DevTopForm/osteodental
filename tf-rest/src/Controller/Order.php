<?php

namespace TFRest\Controller;

use TFRest\CRUDController;
use TFRest\Response;
use TFRest\Service\Order as OrderService;

class Order extends CRUDController
{
    public function indexAction(array $urlParts = []): Response
    {
        $filters = [];

        $filters["from"] = $_GET["from"] ? "DATE(date) >= '" . date('Y-m-d H:i:s', $_GET["from"]) . "'" : null;
        $filters["till"] = $_GET["till"] ? "DATE(date) <= '" . date('Y-m-d H:i:s', $_GET["till"]). "'" : null;

        foreach ($filters as $key => $value) {
            if (empty($value)) {
                unset($filters[$key]);
            }
        }

        if (!empty($urlParts[1]) && $urlParts[1] === "count") {
            $items = (new OrderService())->getList($filters, ["date ASC"], null);
            return new Response(count($items));
        }

        $items = (new OrderService())->getList($filters, ["date ASC"], $_GET["count"]);

        return new Response($items);
    }
}