<?php

use App\Image;
use App\Item\Catalog;
use App\Module\Results;
use App\Node;
use App\Node\Item;
use App\Structure;
use App\Template;
use App\Registry;

function prepareItems($items)
{
    $imageFields = ["image"];
    $imageParamsFields = [];
    foreach ($items as $item) {
        foreach ($imageFields as $imageField) {
            if (!empty($item->$imageField) && !is_object($item->$imageField)) {
                $item->$imageField = new Image($item->$imageField);
            }
        }
        foreach ($imageParamsFields as $imageParamsField) {
            if (!empty($item->params[$imageParamsField]) && !is_object($item->params[$imageParamsField])) {
                $item->params[$imageParamsField] = new Image($item->params[$imageParamsField]);
            }
        }

        if ($item->gallery) {
            if (!is_array($item->gallery)) {
                $item->gallery = explode(';', $item->gallery);
                $imgs = [];
                foreach ($item->gallery as $key => $imgId) {
                    if (!empty($imgId)) {
                        $img = new Image($imgId);
                        if ($img->id) {
                            $imgs[] = $img;
                        }
                    }
                }

                $item->gallery = $imgs;
            }
        }
    }
    unset($item);

    return $items;
}

function fetchTemplate($vars, $template): string
{
    $tpl = new Template();
    foreach ($vars as $var => $val) {
        $tpl->assign($var, $val);
    }

    $settings = Registry::get('settings');
    $tpl->assign('params', $settings->getSiteParams());

    return $tpl->fetch($template);
}

function getOffersTemplate($params, $smarty): string
{
    $items = [];
    Item::$itemsTable = "content_news";

    if ($params["ids"]) {
        $items = Item::getList(["filters" => ["public = 1", "id IN (" . $params["ids"] . ")"], "sorters" => ["sorter ASC"]])->getItems();
    } elseif ($params["id"]) {
//        $struct = Structure::get_instance();
//        $n_data = $struct->get_node_by_url($_REQUEST['q']);
//        $node = new Node($n_data['id'], $n_data);
//
//        $filters = $node->getFilters($node->getCategories());
//        $filters["public"] = "public = 1";
//        $filters["not_id"] = "id != " . $params["id"];
//
//        $products = Catalog::getList(["filters" => $filters, "sorters" => ["sorter ASC"]], 15)->getItems();
    } else {
        $items = Item::getList(["filters" => ["public = 1", "node = 4290"], "sorters" => ["sorter ASC"]])->getItems();
    }

    return fetchTemplate(["content" => prepareItems($items), "class" => $params["class"]], 'module/plugins/offers_slider.tpl');
}


function getResultsTemplate($params, $smarty): string
{
    $items = [];
    Item::$itemsTable = "content_results";

    if ($params["ids"]) {
        $items = Item::getList(
            ["filters" => ["public = 1", "id IN (" . $params["ids"] . ")"], "sorters" => ["sorter ASC"]]
        )->getItems();
    } elseif ($params["id"]) {
    }

    foreach ($items as &$item) {
        $item = Results::prepareItem($item);
    }

    return fetchTemplate(["content" => $items, "title" => $params["title"], "class" => $params["class"]],
        'module/plugins/results.tpl');
}

function getServicesTemplate($params, $smarty): string
{
    $items = [];

    if ($params["ids"]) {
        $items = Node::getList(
            ["filters" => ["public = 1", "id IN (" . $params["ids"] . ")"], "sorters" => ["weight ASC"]]
        )->getItems();
    } elseif ($params["id"]) {
    }

    return fetchTemplate(["content" => prepareItems($items), "class" => $params["class"], "title" => $params["title"]],'module/plugins/services.tpl');
}

function getPricesTemplate($params, $smarty): string
{
    $groups = [];

    if ($params["nodes"]) {
        $nodes = Node::getList(
            ["filters" => ["public = 1", "id IN (" . $params["nodes"] . ")"], "sorters" => ["weight ASC"]]
        )->getItems();

        foreach ($nodes as $node) {
            $groups[$node->id]["node"] = $node;
            $groups[$node->id]["items"] = $node->getItems(["filters" => ["public = 1"], "sorters" => ["sorter ASC"]])->getItems();
        }
    }

    if ($params["ids"]) {
        Item::$itemsTable = "content_prices";
        $items = Item::getList(["filters" => ["public = 1", "id IN (" . $params["ids"] . ")"], "sorters" => ["sorter ASC"]])->getItems();
        foreach ($items as $item) {
            if (empty($groups[$item->node->id])) {
                $groups[$item->node->id]["node"] = $item->node;
                $groups[$item->node->id]["items"][] = $item;
            } elseif (!in_array($item, $groups[$item->node->id]["items"])) {
                $groups[$item->node->id]["items"][] = $item;
            }
        }
    }

    usort($groups, fn($a, $b) => $a["node"]->weight <=> $b["node"]->weight);

    return fetchTemplate(["content" => $groups],'module/plugins/prices.tpl');
}