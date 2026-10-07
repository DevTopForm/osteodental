<?php

namespace TFRest\Controller;

use TFRest\CRUDController;
use TFRest\Response;
use TFRest\Service\Feedback as FeedbackService;

class Feedback extends CRUDController
{
    public function indexAction(array $urlParts = []): Response
    {
        $filters = [];

        $filters["from"] = $_GET["from"] ? "date >= {$_GET["from"]}" : null;
        $filters["till"] = $_GET["till"] ? "date <= {$_GET["till"]}" : null;

        foreach ($filters as $key => $value) {
            if (empty($value)) {
                unset($filters[$key]);
            }
        }

        if (!empty($urlParts[1]) && $urlParts[1] === "count") {
            $items = (new FeedbackService())->getList($filters, ["date ASC"], null);
            return new Response(count($items));
        }

        $items = (new FeedbackService())->getList($filters, ["date ASC"], $_GET["count"]);

        return new Response($items);
    }
}