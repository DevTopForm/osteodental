<?php

namespace App\Site\Controller;

use App\Item\Catalog;
use App\Item\Promocode;
use App\Query;
use App\Site\Controller;
use App\Site\Basket as SiteBasket;
use App\Template;
use App\Utils;

class Basket extends Controller
{
    public function isDispatchable($pathStr): false|int
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match('/^basket\/.*$/', $pathStr);
    }

    public function run(): void
    {
        $success = false;
        $data = [];

        $item = new Catalog((int)Query::$request['product_id']);

        switch ($this->path[1]) {
            case 'add':
                if (empty($item->id) || empty(Query::$post['variation_id'])) {
                    break;
                }

                $variant = $item->getVariant(Query::$post['variation_id']);

                if (!empty($variant["id"])) {
                    $count = (int)Query::$get['count'] ?: 1;

                    if (SiteBasket::getInstance()->isAdded($item, $variant)) {
                        $data = ["message" => "Товар с такими параметрами уже добавлен!"];
                    } else {
                        SiteBasket::getInstance()->addItem($item, $count, $variant);
                        $success = true;
                        $data = ["cart_count" => SiteBasket::getInstance()->getTotal()["count"]];
                    }
                }

                break;

            case 'count':
                if (empty($item->id)) {
                    break;
                }

                if (isset(Query::$get['variant'])) {
                    $key = ((int)Query::$get['item']) . '-' . ((int)Query::$get['variant']);
                } else {
                    $key = (int)Query::$get['item'];
                }
                SiteBasket::getInstance()->setCount($key, (int)Query::$get['count']);
                $success = true;
                break;

            case 'remove':
                if (empty($item->id) || empty(Query::$get['variation_id'])) {
                    break;
                }

                $variant = $item->getVariant(Query::$get['variation_id']);

                if (!empty($variant["id"])) {
                    $basket = SiteBasket::getInstance();
                    $key = $basket->getKeyForArray($item, $variant);
                    $basket->removeItem($key);
                    Utils::redirectPrevious();
                }

                break;
        }

        $result = [
            'success' => $success,
            'data' => $data,
        ];
        echo json_encode($result);
        die;
    }

    protected static function processPromocode(): void
    {
        if (!empty(Query::$get['coupon_code']) && Promocode::codeActive(Query::$get['coupon_code'])) {
            $_SESSION['promocode'] = Query::$get['coupon_code'];
            Utils::redirect("/service/basket");
        } elseif (!empty(Query::$get['remove_coupon']) && isset($_SESSION['promocode'])) {
            unset($_SESSION['promocode']);
            Utils::redirect("/service/basket");
        }
    }

    public static function fetchTemplate(): string
    {
        $tpl = new Template();

        static::processPromocode();

        $items = SiteBasket::getInstance()->getItems();
        $prices = SiteBasket::getInstance()->getPrices();
        $promocode = !empty($_SESSION['promocode']) ? $_SESSION['promocode'] : '';

        $tpl->assign('content', $items);
        $tpl->assign('prices', $prices);
        $tpl->assign('promocode', $promocode);

        return $tpl->fetch('module/basket/default.tpl');
    }
}
