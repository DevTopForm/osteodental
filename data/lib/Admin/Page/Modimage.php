<?php


namespace App\Admin\Page;

use App\Image\Size;
use App\Query;
use App\Utils;
use App\Image\Setting as ImageSetting;

class Modimage extends ModLAVED
{

    protected $localTpl = 'content/modimage.tpl';

    protected function setItemFields()
    {
        $this->item->type = $this->module->type;
        $this->item->title = strip_tags(Query::$post['title']);
        $this->item->name = Utils::translit(strip_tags(Query::$post['name']));
        $this->item->width = (int)Query::$post['width'];
        $this->item->height = (int)Query::$post['height'];
        $this->item->watermark = empty(Query::$post['watermark']) ? 0 : 1;
    }

    protected function afterSaveItem()
    {
        ImageSetting::getInstance()->refresh($this->item->type, $this->item->name);
        Utils::redirect($this->pathPrefix . '/list/' . $this->module->id);
    }

    protected function afterDeleteItem()
    {
        ImageSetting::getInstance()->refresh($this->item->type, $this->item->name);
        Utils::redirect($this->pathPrefix . '/list/' . $this->module->id);
    }

    protected function getItem()
    {
        return new Size($this->extractItemId());
    }

    protected function getItemsList()
    {
        return Size::getList($this->getParameters());
    }

}