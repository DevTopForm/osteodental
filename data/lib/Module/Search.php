<?php

namespace App\Module;

use App\Control\Filter\Text;
use App\Control\Pager;
use App\Image;
use App\Node;
use App\Query;

class Search extends Listing
{

    public $basket = [];
    public $words = [];
    public $result = [];
    public $resultIds = [];
    public $count = 0;
    private $perPage = 50;
    private $_stopList = [
        'для'
    ];


    protected function can_cache()
    {
        if (Query::$get['s']) {
            return false;
        }
        return true;
    }

    public function prepareContent()
    {
        $this->data['searchNode'] = $this->getSearchNode();

        if (!empty($this->ajax)) {
            $this->data['ajax'] = $this->ajax;
        }

        if (!empty($this->area) && !empty($this->area->area)) {
            $this->prepareBlockContent();
        } else {
            if (isset(Query::$get['s'])) {
                $this->search_str = str_replace('Ё', 'Е', str_replace('ё', 'е', strip_tags(trim(Query::$get['s']))));
                $this->search_str = trim($this->search_str);
                $this->search_str = str_replace('"', '', $this->search_str);
                if (!empty($this->search_str)) {
                    $this->doSearch();

                    if (!empty($this->results)) {
                        $pager = new Pager();
                        $pager->init(count($this->results), '', $this->perPage);
                        $pager->bindWith(new Text('s'));
                        $this->data['results'] = $this->getResultsByPage($this->results);
                        $this->data['pager'] = $pager;
                        $this->data['count'] = $this->count;
                    }
                }
                $this->data['search_str'] = $this->search_str;
            }
        }
        if (isset(Query::$get['s'])) {
            $this->data['s'] = Query::$get['s'];
        }
    }

    protected function doSearch()
    {
        $this->words = explode(' ', $this->search_str);
        if (empty($this->words)) {
            return;
        }

        foreach (['full', 'word', 'part'] as $mode) {
            foreach (['title', 'text'] as $field) {
                $this->search_by_type('services', $field, $mode);
                $this->search_by_type('news', $field, $mode);
            }
        }
    }

    protected function prepareBlockContent()
    {
    }

    public static function isStringConsistOfArray(string $str, array $arr): bool
    {
        foreach ($arr as $word) {
            if (stripos(mb_strtolower($str), mb_strtolower($word)) !== false) {
                return true;
            }
        }
        return false;
    }

    private function search_by_type($type = 'catalog', $field = 'title', $mode = 'full')
    {
        if ($mode === 'full') {
            $filter = [];
            $filter[] = sprintf('`%s` LIKE "%s"', $field, $this->search_str);
            $filter[] = sprintf('`%s` LIKE "%s %%"', $field, $this->search_str);
            $filter[] = sprintf('`%s` LIKE "%% %s"', $field, $this->search_str);
            $filter[] = sprintf('`%s` LIKE "%% %s %%"', $field, $this->search_str);
            $filter = sprintf('(%s)', implode(' OR ', $filter));

            $this->getResults($type, $filter);
        } else {
            switch ($mode) {
                case 'word':
                    $pattern =
                        [
                            '`%s` LIKE "%s"',
                            '`%s` LIKE "%s %%"',
                            '`%s` LIKE "%% %s"',
                            '`%s` LIKE "%% %s %%"'
                        ];
                    break;
                case 'part':

                    if (count($this->words) !== 1) {
                        return;
                    }
                    $pattern = '`%s` LIKE "%%%s%%"';
                    break;
                default:
                    return;
            }

            foreach ($this->words as $word) {
                if (in_array(strtolower($word), $this->_stopList)) {
                    continue;
                }

                if (!empty($word)) {
                    $word = trim($word);
                    if (is_array($pattern)) {
                        $filterParts = [];

                        foreach ($pattern as $patternItem) {
                            $filterParts[] = sprintf($patternItem, $field, $word);
                        }

                        $filter = sprintf('(%s)', implode(' OR ', $filterParts));
                    } else {
                        $filter = sprintf($pattern, $field, $word);
                    }

                    $this->getResults($type, $filter);
                }
            }
        }
    }

    public function getResults($type, $filter)
    {
        $search_params = [
            'filters' => [
                $filter,
            ],
        ];

        $limit = null;

        \App\Node\Item::$itemsTable = 'content_' . $type;
        $list = \App\Node\Item::getList($search_params, $limit)->getItems();
        foreach ($list as $key => $item) {
            if (empty($this->resultIds[$type][$item->id])) {
                $this->resultIds[$type][$item->id] = $item->id;
                if ((isset($item->public) && !$item->public) || !$item->node->public) {
                    continue;
                }
                $this->results[] = self::prepareSearchItem($item);

                $this->count++;
            }
        }
    }

    static function prepareSearchItem($item)
    {
        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        if (!$item->title) {
            $item->title = $item->node->title;
        }

        $item->url = $item->getUrl();

        $nodes = [$item->node];
        $node = $item->node;
        while ($node = $node->getParentNode()) {
            $nodes[] = $node;
        }

        $item->chain = array_reverse($nodes);

        return $item;
    }

    protected function getSearchNode()
    {
        \App\Node\Item::$itemsTable = 'nodes';
        $parameters['filters'][] = "`type` = 'search'";
        $node = \App\Node\Item::getList($parameters)->getItems();
        if ((!empty($node)) && (count($node) == 1)) {
            return $node[0];
        }
        return null;
    }


    protected static function prepareCatalogItem($item)
    {
        $item = self::prepareItem($item);

        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        return $item;
    }


    protected static function prepareVariants($items)
    {
        if (!empty($items)) {
            foreach ($items as $key => $value) {
                if (!empty($value->images_variant) && !is_array($value->images_variant)) {
                    $value->images_variant = explode(';', $value->images_variant);

                    foreach ($value->images_variant as $keyImage => $valueImage) {
                        if (!empty($valueImage) && !is_object($valueImage)) {
                            $value->images[$keyImage] = new Image($valueImage);
                        }
                    }
                } elseif (empty($value->images_variant)) {
                    $value->images = [];
                }

                if (!empty($value->image_variant) && !is_object($value->image_variant)) {
                    $value->image = new Image($value->image_variant);
                }

                if (!empty($value->image)) {
                    array_unshift($value->images, $value->image);
                }

                $items[$key] = $value;
            }
        }

        return $items;
    }

    public function getResultsByPage($results, $page = 0)
    {
        $results = array_chunk($results, $this->perPage);

        if (!empty(Query::$get['page'])) {
            $page = Query::$get['page'] - 1;
        }

        return $results[$page] ?? [];
    }
}