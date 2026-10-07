<?php

namespace App\Site\Controller;

use App\Node;
use App\Site\Controller;
use App\Structure;
use App\Utils;

class Page extends Controller
{

    public function isDispatchable($pathStr)
    {
        return true;
    }

    public function run()
    {
        $url = join('/', $this->path);
        $struct = Structure::get_instance();
        $n_data = $struct->get_node_by_url($url);
        $node = new Node($n_data['id'], $n_data);
        if (!empty($node->id) && $node->public) {
            if (!empty($node->redirect)) {
                Utils::redirect($node->redirect);
            } else {
                if ($node->id == '3') {
                    header('HTTP/1.0 404 Not Found');
                    $notFound = Site_NotFound::getInstance();
                    $notFound->display();
                }
                $node->display();
            }
        } else {
            header('HTTP/1.0 404 Not Found');
            $n_data = $struct->get_node_by_url('');
            $node = new Node($n_data['id']);
            $node->display_not_found();
        }
    }
}
