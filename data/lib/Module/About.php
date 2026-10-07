<?php

namespace App\Module;

use App\File;
use App\Form\Complex;
use App\Image;
use App\Registry;

class About extends Item
{
    protected function prepareBlockContent()
    {
        $this->params = $this->node->getParams($this->area->area);
        $items = $this->node->getItems()->getItems();
        $item = array_shift($items);

        if(
            !empty($item->images)
            && !is_array($item->images)
        ){
            $item->images = array_map(function($image){
                return new Image($image);
            }, explode(";", $item->images));
        }

        $item->files = ($item->files) ? Complex::getDisplayValue($item->files) : [];

        $db = Registry::get('db');
        $IDs = $db->query('SELECT `id` FROM `content_staff` WHERE `public` = 1', $db::QUERY_MODE_EXECUTE)->toArray();
        $IDs = implode(',', array_column($IDs, 'id'));
        $item->staff = self::getStaffByIDs($IDs);

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

        if(
            !empty($item->images)
            && !is_array($item->images)
        ){
            $item->images = array_map(function($image){
                return new Image($image);
            }, explode(";", $item->images));
        }

        $this->data['content'] = $item;
    }
}