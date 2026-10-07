<?php

namespace App\Module;

use App\Image;
use App\Node;

class Text extends Item
{

    protected function prepareMainContent()
    {
        $this->params = $this->node->getParams(0);
        $items = $this->node->getItems()->getItems();
        $item = array_shift($items);
        $doptext = '';

        if (!empty($item)) {
            $item->meta_title = (!isset($item->meta_title) || empty($item->meta_title)) ? $item->node->title : $item->meta_title;
        }
        $this->node->meta_title = !empty($this->node->meta_title) ? $this->node->meta_title : (empty($item->meta_title) ? $this->node->title . $doptext : $item->meta_title);
        $this->node->meta_keywords = empty($item->meta_keywords) ? $this->node->meta_keywords : $item->meta_keywords;
        $this->node->meta_description = empty($item->meta_description) ? $this->node->meta_description : $item->meta_description;
        if (!empty($item->id) && !empty($this->params['comments'])) {
            $this->addComment($item);
            $item->comments = $this->getComments($this->node, $item);
        }
        if (!empty($this->params['service'])) {
            $services = explode(',', $this->params['service']);
            $final_service = array();
            if (!empty($services)) {
                foreach ($services as $service) {
                    $final_service[] = new Node($service);
                }
            }
            $this->params['service'] = $final_service;
        } else {
            $this->params['service'] = array();
        }
        if (!empty($this->params['other_service'])) {
            $other_services = explode(',', $this->params['other_service']);
            $final_other_service = array();
            if (!empty($other_services)) {
                foreach ($other_services as $other_service) {
                    $final_other_service[] = new Node($other_service);
                }
            }
            $this->params['other_service'] = $final_other_service;
        } else {
            $this->params['other_service'] = array();
        }

        $this->params = $this->node->getParams($this->area->area);

        if (!empty($this->params["bg_about"]) && !is_object($this->params["bg_about"])) {
            $this->params["bg_about"] = new Image($this->params["bg_about"]);
        }

        $this->data['content'] = $item;
    }
}
