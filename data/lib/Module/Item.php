<?php

namespace App\Module;

use App\Image;

class Item extends Model
{

    public function prepareContent()
    {
        if (!empty($this->area)) {
            return $this->prepareBlockContent();
        } else {
            return $this->prepareMainContent();
        }
    }

    protected function prepareBlockContent()
    {
        $this->params = $this->node->getParams($this->area->area);
        $items = $this->node->getItems()->getItems();
        $item = array_shift($items);

        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        $this->data['content'] = $item;
    }

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

        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        $this->data['content'] = $item;
    }

}