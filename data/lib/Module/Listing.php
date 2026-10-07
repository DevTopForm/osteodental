<?php

namespace App\Module;

use App\Control\Element;
use App\Image;
use App\Node;
use App\Query;
use App\Node\Item as NodeItem;
use App\Node\Field\Item as NodeFieldItem;
use App\Site\Breadcrumb;
use App\Structure;
use App\Utils;

class Listing extends Model
{

    public function prepareContent()
    {
        $this->params = $this->node->getParams(empty($this->area) ? 0 : $this->area->area);
        if (!empty($this->area)) {
            return $this->prepareContentBlock();
        } else {
            return $this->prepareContentMain();
        }
    }

    protected function prepareContentBlock()
    {
        $rs = $this->prepareList($this->getBlockParameters());
        $this->data['area'] = $this->area;
        $this->data['content'] = $rs->getItems();
        $this->data['categories'] = $this->getCategories();
    }

    protected function prepareContentMain()
    {
        $this->params = $this->node->getParams(0);
        $url = parse_url(Query::$get['url']);
        if (!empty($url['path'])) {
            $nodeParts = explode('/', trim($this->node->getUrl(), '/'));
            $urlParts = explode('/', $url['path']);
            if (count($urlParts) == (count($nodeParts) + 1)) {
                $item = NodeItem::getByAlias(array_pop($urlParts), $this->node);
                if (!empty($item->id)) {
                    return $this->parseMainContentItem($item);
                } else {
                    Utils::redirect('/service/404?from=' . $this->node->getUrl());
                }
            } elseif (count($urlParts) == count($nodeParts)) {
                return $this->parseMainContentList();
            } else {
                Utils::redirect('/service/404?from=' . $url['path']);
            }
        } else {
            return $this->parseMainContentList();
        }
    }

    protected function parseMainContentItem($item)
    {
        $this->tpl_file = 'module/' . $this->node->getType() . '/item.tpl';
        $item = $this->prepareMainItem($item);
        Breadcrumb::getInstance()->setItem($item);
        $this->node->meta_title = empty($item->meta_title) ? sprintf(
            "%s %s %s",
            $item->title,
            '-',
            $this->node->title
        ) : $item->meta_title;
        $this->node->meta_keywords = empty($item->meta_keywords) ? $this->node->meta_keywords : $item->meta_keywords;
        $this->node->meta_description = empty($item->meta_description) ? $this->node->meta_description : $item->meta_description;
        if (!empty($this->params['comments'])) {
            $this->addComment($item);
            $item->comments = $this->getComments($this->node, $item);
        }
        $this->data['content'] = $item;
    }

    protected function parseMainContentList()
    {
        $rs = $this->prepareList($this->getMainParameters());
        $this->data['content'] = $rs->getItems();
        $this->data['categories'] = $this->getCategories();
        $this->data['pager'] = $rs->getPager()->getHtml();
        $this->data['filters'] = $this->getFiltersHtml();
        $this->data['blocks'] = $this->parseMainContentListBlocks();
    }

    protected function parseMainContentListBlocks()
    {
        return [];
    }

    protected function prepareMainItem($item)
    {
        $item = static::prepareItem($item);


        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }
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
        $alt = empty($params['alt_template_catalog']) ? $item->title : str_replace(
            $from,
            $to,
            $params['alt_template_catalog']
        );
        if (!empty($item->image->id)) {
            $item->image->alt = $alt;
        }
        $alt_ind = 0;
        foreach ($item->images as $key => $image) {
            $item->images[$key]->alt = $alt . " " . ++$alt_ind;
        }
        if ($item->node->type->has_variants) {
            $item->variants = $item->getVariants();
        }
        return $item;
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

        $rs = $this->node->getItems($params, $params['pager']);
        $items = [];
        foreach ($rs->getItems() as $item) {
            $item->params = $this->params;
            $items[] = static::prepareItem($item);
        }
        $rs->setItems($items);
        return $rs;
    }

    protected function getCategories()
    {
        $parentId = $this->node->id;
        $parentType = $this->node->getType();

        $tree = Structure::get_instance()->get_tree($parentId);
        $cats = [];

        foreach ($tree as $key => $node) {
            if (!$node['public'] || $node['type'] != $parentType) {
                unset($tree[$key]);
                continue;
            }

            $node = new Node($node['id'], $node);

            $cats[$node->id] = $node;
        }

        return $cats;
    }

    protected static function prepareItem($item)
    {
        $item->getUrl();

        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        if ($item->node->type->has_variants) {
            $item->variants = $item->getVariants();
        }

        if ($item->gallery) {
            if (!is_array($item->gallery)) {
                $item->gallery = explode(';', $item->gallery);
                $imgs = [];
                foreach ($item->gallery as $key => $imgId) {
                    if (!empty($imgId)) {
                        $img = new Image($imgId);
                        if ($img->id) {
                            $imgs[] = $img;
                        }
                    }
                }

                $item->gallery = $imgs;
            }
        }

        return $item;
    }

    protected function getMainParameters()
    {
        $parameters = [
            'filters' => $this->getMainFilters(),
            'sorters' => $this->getMainSorters(),
        ];
        $this->filters = $this->prepareFilters($parameters);
        return $parameters;
    }

    protected function prepareFilters($parameters = [])
    {
        $filters = [];
        foreach ($parameters as $group) {
            foreach ($group as $key => $filter) {
                $filters[$key] = $filter;
            }
        }
        foreach ($filters as $key => $filter) {
            foreach ($filters as $bindFilter) {
                if ($filter instanceof Element && $filter !== $bindFilter) {
                    $filters[$key]->bindWith($filter);
                }
            }
        }
        return $filters;
    }

    protected function getBlockParameters()
    {
        return [
            'filters' => $this->getBlockFilters(),
            'sorters' => $this->getBlockSorters(),
        ];
    }

    protected function getBlockFilters()
    {
        return [
            'public' => 'public = 1',
        ];
    }

    protected function getBlockSorters()
    {
        if (!empty($this->params['sorter'])) {
            $field = new NodeFieldItem((int)$this->params['sorter']);
            if (!empty($field->id)) {
                return [
                    'sorter' => sprintf(
                        '%s %s',
                        $field->name,
                        empty($this->params['sortorder']) ? 'ASC' : 'DESC'
                    )
                ];
            }
        }
        return ['sorter' => 'id ASC'];
    }

    protected function getMainFilters()
    {
        return [
            'public' => 'public = 1',
        ];
    }

    protected function getMainSorters()
    {
        if (!empty($this->params['sorter'])) {
            $field = new NodeFieldItem((int)$this->params['sorter']);
            if (!empty($field->id)) {
                return [
                    'sorter' => sprintf(
                        '%s %s',
                        $field->name,
                        empty($this->params['sortorder']) ? 'ASC' : 'DESC'
                    )
                ];
            }
        }
        return ['sorter' => 'id ASC'];
    }

    protected function getFiltersHtml()
    {
        $filters = [];
        foreach ($this->filters as $key => $filter) {
            if ($filter instanceof Element) {
                $filters[$key] = $filter->getHTML();
            }
        }
        return $filters;
    }
}

?>
