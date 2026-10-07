<?php

namespace App\Item;

use App\Form\Complex;
use App\Image;
use App\Item;
use App\Node;
use App\Registry;
use App\Searcher;
use App\Cabinet\Map as CabinetMap;
use App\Site\Basket as SiteBasket;
use App\Site\Favorite as SiteFavorite;

class Catalog extends Item
{

    protected $table = 'content_catalog';
    protected $defaultSorter = 'id';
    protected $defaultOrder = 'ASC';

    protected function prepareData()
    {
        $this->node = new Node($this->node);

        foreach (json_decode($this->properties, JSON_UNESCAPED_UNICODE) as $propertyKey => $propertyValue) {
            $this->$propertyKey = $propertyValue;
        }

        if ($this->variants) {
            $this->variants = Complex::getDisplayValue($this->variants);
        }

        if (!empty($this->image) && !is_object($this->image) && !is_array($this->image)) {
            $this->image = new Image($this->image);
        }

        if ($this->gallery) {
            if (!is_array($this->gallery)) {
                $this->gallery = explode(';', $this->gallery);
                $imgs = [];
                foreach ($this->gallery as $key => $imgId) {
                    if (!empty($imgId)) {
                        $img = new Image($imgId);
                        if ($img->id) {
                            $imgs[] = $img;
                        }
                    }
                }

                $this->gallery = $imgs;
            }
        }

        $tags = [];
        if (!empty($this->tags)) {
            Node\Item::$itemsTable = "content_list";
            $tagObjs = Node\Item::getList(
                ["filters" => ["public = 1", "id IN (" . $this->tags . ")"], "sorters" => ["sorter ASC"]]
            )->getItems();

            foreach ($tagObjs as $tag) {
                $tags[] = [
                    "id" => $tag->id,
                    "title" => $tag->title,
                    "sorter" => $tag->sorter,
                ];
            }
        }
        $this->tags = $tags;
    }

    public function getUrl(): string
    {
        if (empty($this->url)) {
            $this->url = $this->node->getUrl() . (empty($this->alias) ? ('?id=' . $this->id) : ('/' . $this->alias));
        }
        return $this->url;
    }

    public function isInBasket(): bool
    {
        return !empty(SiteBasket::getInstance()->getItem($this->id));
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    // возвращает строку содержащую выборку id из базы
    public static function getIdCatalogList($parameters = [], $limiter = null, $class = self::class): string
    {
        if (!empty($parameters['filters']['main'])) {
            $parameters['filters'] = array_merge($parameters['filters'], $parameters['filters']['main']);
            unset($parameters['filters']['main']);
        }
        $searcher = self::prepareSearcher($parameters, $limiter, $class);
        $recordSet = $searcher->search();
        $items = '';
        foreach ($recordSet->getItems() as $item) {
            $items .= $item['id'] . ',';
        }
        return substr($items, 0, -1);
    }

    public function isFavorite(): bool
    {
        return SiteFavorite::getInstance()->inList($this->id);
    }

    public function getVariantAttributes($fieldName): array
    {
        $attrs = [];

        if (empty($this->variants)) {
            return [];
        }

        foreach ($this->variants as $variant) {
            if ($variant[$fieldName]) {
                $attrs[] = $variant[$fieldName];
            }
        }

        $attrs = array_filter(array_unique($attrs));
        usort($attrs, function ($a, $b) {
            return $a <=> $b;
        });

        return $attrs;
    }

    public function getVariantsByKeys(array $filters): array
    {
        if (empty($this->variants)) {
            return [];
        }

        $variants = [];

        foreach ($this->variants as $variant) {
            $isMatch = true;
            foreach ($filters as $key => $value) {
                if (!$variant[$key] || $variant[$key] != $value) {
                    $isMatch = false;
                    break;
                }
            }

            if ($isMatch) {
                $variants[] = $variant;
            }
        }

        return $variants;
    }

    public function getVariant(int $id): array|null
    {
        return $this->variants[$id] ?? null;
    }
}
