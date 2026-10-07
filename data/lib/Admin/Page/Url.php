<?php

namespace App\Admin\Page;

use App\Node\Item;
use App\Query;
use App\Structure;
use App\Utils;

class Url extends NodeLAVED
{

    protected function parseContent(): void
    {
        if (!empty(Query::$get['url'])) {
            $url_expl = explode('/', Query::$get['url']);
            array_shift($url_expl);
            $url = implode('/', $url_expl);
        }

        $struct = Structure::get_instance();
        if ($url) {
            $node = $struct->get_node_by_url($url);
            if ($node === null) {
                Utils::redirect('/adm');
            } else {
                $node_obj = new \App\Node($node['id']);
                $itemID = 0;
                if (empty(Query::$get['id'])) {
                    $url = parse_url(Query::$get['url']);
                    if (isset($url['path'])) {
                        $parts = array_diff(explode('/', $url['path']), ['']);
                        $last_part = array_pop($parts);
                        if ($node_obj->alias != $last_part) {
                            $item = Item::getByAlias($last_part, $node_obj);
                            if (!empty($item)) {
                                $itemID = $item->id;
                            }
                        }
                    }
                } else {
                    $itemID = Query::$get['id'];
                }
                Utils::redirect(
                    '/adm/content/' . ($itemID ? 'edit' : 'list') . '/' . $node['id'] . ($itemID ? '/' . $itemID : '')
                );
            }
        } else {
            Utils::redirect('/adm');
        }
    }
}