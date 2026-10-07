<?php

namespace App\Module;

use App\File;
use App\Form\Complex;
use App\Image;
use App\Node;
use App\Node\Item as NodeItem;
use App\Query;

class Results extends Listing
{
    public static function prepareItem($item)
    {
        foreach (['image', 'video_cover', 'video_cover_2'] as $image) {
            if (!empty($item->$image) && !is_object($item->$image)) {
                $item->$image = new Image($item->$image);
            }
        }

        foreach (['video'] as $file) {
            if (!empty($item->$file) && !is_object($item->$file)) {
                $item->$file = new File($item->$file);
            }
        }

        if(
            !empty($item->images)
            && !is_array($item->images)
        ){
            $item->images = array_map(function($image){
                return new Image($image);
            }, explode(";", $item->images));
        }

        $item->staff = self::getStaffByIDs($item->staff);

        return $item;
    }

    protected function parseMainContentList()
    {
        $rs = $this->prepareList($this->getMainParameters());
        $this->data['content'] = $rs->getItems();
//        pre($this->data['content']);
        $this->data['categories'] = $this->getCategories();
        $this->data['pager'] = $rs->getPager()->getHtml();
        $this->data['filters'] = $this->getFiltersHtml();
        $this->data['blocks'] = $this->parseMainContentListBlocks();
    }

    protected function prepareList($params = [])
    {
        if (isset($this->params['random']) && $this->params['random']) {
            $params['sorters'] = ['RAND()'];
        }
        if (empty($this->params['pager'])) {
            $params['pager'] = null;
        } else {
            $params['pager'] = (int)$this->params['pager'];
        }

        if ($params["filters"]["node"]) {
            $node = new \App\Node($params["filters"]["node"]);
        } else {
            $node = $this->node;
        }
        $rs = $node->getItems($params, $params['pager']);
        
        $items = [];
        foreach ($rs->getItems() as $item) {
            $item->params = $this->params;
            $items[] = static::prepareItem($item);
        }
        $rs->setItems($items);
        return $rs;
    }
    protected function getMainFilters()
    {
        return [
            'public' => 'public = 1',
//            'node' => '4356'
        ];
    }

    protected function getMainSorters()
    {
        return ['sorter' => 'sorter ASC'];
    }
    
    public static function getResultsByStaffID($staff_id)
    {
        $filters = [
          'public = 1',
            sprintf(
                '`staff` REGEXP "(^%d\,)|(\,%d\,)|(^%d$)|(\,%d$)"',
                $staff_id,
                $staff_id,
                $staff_id,
                $staff_id
            )
        ];

        NodeItem::$itemsTable = 'content_results';
        $result = NodeItem::getList([
            'filters' => $filters,
            'sorters' => [
                'sorter ASC'
            ]
        ])->getItems();

        return array_map([self::class, 'prepareItem'], $result);
    }
}