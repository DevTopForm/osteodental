<?php

namespace App\Module;

use App\Form\Complex;
use App\Image;

class Contacts extends Item
{
    protected function prepareMainContent(): void
    {
        parent::prepareMainContent();
        $item = $this->data['content'];


        if (!empty($this->params["logo"]) && !is_object($this->params["logo"])) {
            $this->params["logo"] = new Image($this->params["logo"]);
        }

        $item->files = ($item->files) ? Complex::getDisplayValue($item->files) : [];

        if (!empty($item->images)) {
            if (!is_array($item->images)) {
                $item->images = explode(';', $item->images);
                foreach ($item->images as $imgId) {
                    if (!empty($imgId)) {
                        $img[$imgId] = new Image($imgId);
                    }
                }
                $item->images = $img;
            }
        } else {
            $item->images = [];
        }

        $this->data['content'] = $item;
    }
}