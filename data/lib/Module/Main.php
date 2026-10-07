<?php

namespace App\Module;

use App\File;
use App\Form\Complex;
use App\Image;
use App\Node;
use App\Structure;
use App\Utils;

class Main extends Item
{

    protected function prepareMainContent(): void
    {
        parent::prepareMainContent();
        $item = $this->data['content'];

        $item->main_links = !empty($item->main_links) ? Complex::getDisplayValue($item->main_links) : [];

        if (!empty($item->partner1_img) && !is_object($item->partner1_img)) {
            $item->partner1_img = new Image($item->partner1_img);
        }
        if (!empty($item->partner2_img) && !is_object($item->partner2_img)) {
            $item->partner2_img = new Image($item->partner2_img);
        }

        $item->stocks = self::getStocksByIDs($item->stocks ?: '');

        if (!empty($item->video_block_preview) && !is_object($item->video_block_preview)) {
            $item->video_block_preview = new Image($item->video_block_preview);
        }
        if (!empty($item->video_block_video) && !is_object($item->video_block_video)) {
            $item->video_block_video = new File($item->video_block_video);
        }

        $item->advantages = !empty($item->advantages) ? Complex::getDisplayValue($item->advantages) : [];

        $item->equipment = self::getEquipmentByIDs($item->equipment ?: '');
        $item->news = self::getNewsByIDs($item->news ?: '');

        if (!empty($item->video_reviews)) {
            Node\Item::$itemsTable = 'content_reviews';
            $item->video_reviews = Node\Item::getList([
                'filters' => [
                    'public = 1',
                    sprintf('id IN (%s)', $item->video_reviews)
                ],
                'sorters' => [
                    'sorter ASC'
                ]
            ])->getItems();

            $item->video_reviews = array_map([static::class, 'prepareReviews'], $item->video_reviews);
        }

        $this->data['content'] = $item;
    }

    public static function prepareReviews($item)
    {
        if(!empty($item->cover)) {
            $item->cover = new Image($item->cover);
        }

        if(!empty($item->video)) {
            $item->video = new File($item->video);
        }

        return $item;
    }
}