<?php

namespace App\Module;

use App\Query;
use App\Item\Region as ItemRegion;
use App\Registry;
use App\Utils;
use App\Geo as AppGeo;

class Geo extends Listing
{
    protected function prepareContentBlock(): void
    {
        $errors = [];
        $listFinal = [];
        $this->db = Registry::get('db');
        if (isset(Query::$post['ajax']) && !empty(Query::$post['ajax'])) {
            if (isset(Query::$post['action']) && !empty(Query::$post['action'])) {
                $action = Query::$post['action'];
                $query = strip_tags(Query::$post['query']);
                $query = trim($query);

                switch ($action) {
                    case 'getregion':
                        $rows = $this->db->fetchAll(
                            "SELECT id, title, region FROM `item_region` WHERE public=1 AND title LIKE '$query%' ORDER BY title ASC LIMIT 8"
                        );

                        if (!empty($rows)) {
                            foreach ($rows as $row) {
                                $listFinal[] = [
                                    $row['id'],
                                    $row['title'] . ' <i>(' . $row['region'] . ')</i>',
                                    $_SERVER['REQUEST_URI'] . '?set-region=1&region=' . $row['id']
                                ];
                            }
                        }
                        break;

                    default:
                        break;
                }
            }
            if (empty($this->data['msgs'])) {
                echo json_encode([
                    'status' => 'success',
                    'regions' => $listFinal,
                ]);
            } else {
                $errors = implode('', $errors);
                echo json_encode([
                    'status' => 'error',
                    'message' => $errors
                ]);
            }

            die;
        } else {
            if (!empty(Query::$get['set-region'])) {
                if (empty(Query::$get['region'])) {
                    $items = ItemRegion::getList(
                        ['filters' => ['public = 1', '`title` = "' . strip_tags(Query::$get['region-title']) . '"']]
                    )->getItems();
                    if (!empty($items)) {
                        $region = $items[0];
                        if (!empty($region->id)) {
                            AppGeo::setRegion($region);
                            $redirect = explode('?', $_SERVER['REQUEST_URI']);
                            Utils::redirect($redirect[0]);
                        }
                    }
                } elseif (!empty(Query::$get['region'])) {
                    $region = new ItemRegion((int)Query::$get['region']);
                    if (!empty($region->id)) {
                        AppGeo::setRegion($region);

                        $redirect = explode('?', $_SERVER['REQUEST_URI']);
                        Utils::redirect($redirect[0]);
                    }
                }
            }

            if (empty($region->id)) {
                $region = AppGeo::getRegion();
            }

            $this->data['region'] = $region;
        }
    }
}