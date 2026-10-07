<?php

namespace App\Site\Controller;

use App\Geo;
use App\Item\Region as ItemRegion;
use App\Query;
use App\Registry;
use App\Site\Controller;
use App\Utils;

class Region extends Controller
{

    public function isDispatchable($pathStr): false|int
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return $pathStr == 'regions';
    }

    public function run(): void
    {
        $db = Registry::get('db');

        if (isset(Query::$post['action']) && !empty(Query::$post['action'])) {
            $listFinal = [];
            $action = Query::$post['action'];
            $query = strip_tags(Query::$post['query']);
            $query = trim($query);

            switch ($action) {
                case 'getregion':
                    {
                        $rows = $db->query(
                            "SELECT id, title, region FROM `item_region` WHERE public=1 AND title LIKE '{$query}%' ORDER BY title ASC LIMIT 8", $db::QUERY_MODE_EXECUTE
                        )->toArray();

                        if (!empty($rows)) {
                            foreach ($rows as $row) {
                                $listFinal[] = [
                                    $row['id'],
                                    $row['title'] . ' <i>(' . $row['region'] . ')</i>',
                                    $_SERVER['REQUEST_URI'] . '?set-region=1&region=' . $row['id']
                                ];
                            }
                        }
                    }
                    break;

                default:
                    break;
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'status' => 'success',
                'regions' => $listFinal,
            ]);
        } else {
            if (!empty(Query::$get['set-region'])) {
                if (empty(Query::$get['region'])) {
                    $region = ItemRegion::getByKey('title', Query::$get['region-title']);

                    if (!empty($region->id)) {
                        Geo::setRegion($region);
                        $redirect = explode('?', $_SERVER['REQUEST_URI']);
                        Utils::redirect($redirect[0]);
                    }
                } else {
                    $region = new ItemRegion((int)Query::$get['region']);
                    if (!empty($region->id)) {
                        Geo::setRegion($region);
                        $redirect = explode('?', $_SERVER['HTTP_REFERER']);
                        Utils::redirect($redirect[0]);
                    }
                }
            }
        }
    }
}