<?php

namespace App\Module;

use App\File;
use App\Form\Complex;
use App\Image;
use App\Node;
use App\Query;

class News extends Listing
{
    protected function parseMainContentList(): void
    {
        $rs = $this->prepareList($this->getMainParameters());
        $this->data['content'] = $rs->getItems();
        $this->data['pager'] = $rs->getPager();

        \App\Node\Item::$itemsTable = "content_list";
        $tags = \App\Node\Item::getList(["filters" => ["public = 1", "node = 4292"], "sorters" => ["sorter ASC"]]
        )->getItems();
        $this->data['tags'] = $tags;
    }

    protected function getMainFilters(): array
    {
        $filters = ['public' => 'public = 1'];

        return $filters;
    }

    protected function getMainSorters(): array
    {
        return ["date DESC", "sorter ASC"];
    }

    public static function prepareItem($item)
    {
        $item->getUrl();

        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        if (!empty($item->video) && !is_object($item->video)) {
            $item->video = new File($item->video);
        }

        if (!empty($item->date)) {
            $item->date = date("d.n.Y", strtotime($item->date));
        }

        return $item;
    }

    protected function prepareMainItem($item)
    {
        Node\Item::$itemsTable = "content_news";
        Node\Item::simpleSave($item->id, "counter", $item->counter + 1);

        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        if (!empty($item->video) && !is_object($item->video)) {
            $item->video = new File($item->video);
        }

        $fields = ['seo_text', 'meta_title', 'meta_keywords', 'meta_description'];

        $from = ['%title%', '%node%'];
        $to = [$item->title, $item->node->title];
        foreach ($fields as $field) {
            $item->$field = empty($item->$field) ? @str_replace(
                $from,
                $to,
                $this->params[$field . '_template']
            ) : $item->$field;
        }

        Node\Item::$itemsTable = "content_staff";
        if (!empty($item->blockquote_staff)) {
            $item->blockquote_staff = Node\Item::getByKey("id", $item->blockquote_staff);
            $item->blockquote_staff = static::prepareItem($item->blockquote_staff);
        }
        if (!empty($item->revisor)) {
            $item->revisor = Node\Item::getByKey("id", $item->revisor);
            $item->revisor = static::prepareItem($item->revisor);
        }

        Node\Item::$itemsTable = "content_news";
        $params = [
            "filters" => ["public = 1", "node = 4279", "id" => "id != " . $item->id],
            "sorters" => ["date DESC", "sorter ASC"]
        ];
        $limiter = 10;

        if (!empty($item->articles)) {
            $params["filters"]["id"] = "id IN (" . $item->articles . ")";
            $limiter = null;
        }

        $item->articles = Node\Item::getList($params, $limiter)->getItems();

        foreach ($item->articles as &$article) {
            $article = static::prepareItem($article);
        }
        unset($article);

        $item->sources = ($item->sources) ? unserialize($item->sources) : [];
        $item->gallery = ($item->gallery) ? Complex::getDisplayValue($item->gallery) : [];
        $item->videos = ($item->videos) ? Complex::getDisplayValue($item->videos) : [];

        return $item;
    }
}