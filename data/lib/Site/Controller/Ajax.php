<?php

namespace App\Site\Controller;

use App\Node;
use App\Query;
use App\Site\Controller;
use App\Structure;
use App\Utils;

class Ajax extends Controller
{

    public function isDispatchable($pathStr): false|int
    {
        $pathStr = $this->removePathPrefix($pathStr);
        return preg_match(
            '/^ajax\/.*$/',
            $pathStr
        );
    }

    public function run()
    {
        $url = $this->path;
        if ($url[0] == 'ajax') {
            unset($url[0]);
            $url = array_values($url);
            $url = implode('/', $url);
        }
        Query::$get['url'] = $url;
        $struct = Structure::get_instance();
        $n_data = $struct->get_node_by_url($url);
        if ($n_data === null || !$n_data['public']) {
            header('HTTP/1.0 404 Not Found');
            $n_data = $struct->get_node_by_url('service/404');
        }
        $node = new Node($n_data['id'], $n_data);
        if (!empty($node->id)) {
            if (!empty($node->redirect)) {
                Utils::redirect($node->redirect);
            } else {
                echo $node->display_ajax();
            }
        }
        die;
    }
}