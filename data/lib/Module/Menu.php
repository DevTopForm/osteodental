<?php

namespace App\Module;

use App\Attach;
use App\Image;
use App\Node;
use App\Node\Setting\Value;
use App\Query;
use App\Registry;
use App\Structure;

class Menu extends Model
{
    protected $str = [];

    public function prepareContent()
    {
        if (!empty($this->area) && !empty($this->area->area)) {
            return $this->prepareBlockContent();
        } else {
            return $this->prepareSpecialContent();
        }
    }

    protected function prepareSpecialContent()
    {
        $this->node->title = $this->mainNode->title;

        $this->params = $this->node->getParams(0);
        $menu = $this->get_current_menu(empty($this->params['parent']) ? 0 : $this->params['parent']);
        $menu = $this->getSitemapItems($this->get_public_sitemap_items($menu));

        return $menu;
    }

    protected function getItemsList($tree)
    {
        foreach ($tree as $value) {
            if (!empty($value['childs'])) {
                $this->getItemsList($value['childs']);
            }
        }
    }

    protected function prepareBlockContent()
    {
        $this->params = $this->node->getParams($this->area->area);

        if (!empty($this->params["banner_img"]) && !is_object($this->params["banner_img"])) {
            $this->params["banner_img"] = new Image($this->params["banner_img"]);
        }

        $menu = $this->get_current_menu(empty($this->params['parent']) ? 0 : $this->params['parent']);
        $menu = $this->get_public_items($menu);
        [$menu,] = $this->mark_active_node($menu);

        $this->data['mainNode'] = $this->mainNode;

        return $menu;
    }

    protected function get_current_menu($parent)
    {
        if ($parent > 0) {
            $this->data['parent'] = new Node($parent);
        }
        if (empty($parent)) {
            return Structure::get_instance()->get_tree();
        } elseif ($parent > 0) {
            return Structure::get_instance()->get_tree($parent);
        } elseif ($parent == 'current') {
            return Structure::get_instance()->get_tree($this->mainNode->parent);
        } else {
            $menu = Structure::get_instance()->get_tree();
            [$menu,] = $this->mark_active_node($menu);
            return $this->get_next_level($menu, abs($parent), 1);
        }
    }

    private function get_next_level($menu, $level = 1, $cur_level = 1)
    {
        if ($level == $cur_level) {
            return $menu;
        }
        $cur_level++;
        foreach ($menu as $item) {
            if (!empty($item['active'])) {
                return $this->get_next_level($item['childs'], $level, $cur_level);
            }
        }
        return $menu;
    }

    private function mark_active_node($tree, $nid = null)
    {
        foreach ($tree as $key => $item) {
            $tree[$key]['active'] = false;
            if (!empty($item['childs'])) {
                [$tree[$key]['childs'], $active] = $this->mark_active_node($item['childs']);
                if ($active) {
                    $tree[$key]['active'] = $active;
                    return [$tree, true];
                }
            }
            if ($this->mainNode->getUrl() == $item['url'] || $this->mainNode->getUrl() == $item['redirect']) {
                $tree[$key]['active'] = true;
                return [$tree, true];
            } elseif ($this->mainNode->getUrl() == '/service/cabinet') {
                $url = $this->mainNode->getUrl() . '/' . Query::$request['url'];
                if ($url == $item['url'] || $url == $item['redirect']) {
                    $tree[$key]['active'] = true;
                    return [$tree, true];
                }
            }
        }
        return [$tree, false];
    }

    private function getSitemapItems($tree)
    {
        $menu = [];
        foreach ($tree as $item) {
            if (!empty($item['sitemap'])) {
                if (!empty($item['childs'])) {
                    $item['childs'] = $this->getSitemapItems($item['childs']);
                }
                $menu[] = $item;
            }
        }
        return $menu;
    }

    private function get_public_items($tree)
    {
        $menu = [];
        $settings = Registry::get('settings');
        $params = $settings->getSiteParams();
        foreach ($tree as $item) {
            if (!empty($item['public']) && empty($item['nomenu'])) {
                if (!empty($item['childs'])) {
                    $item['childs'] = $this->get_public_items($item['childs']);
                }
                if (!empty($item['image'])) {
                    //$item['image_file'] = Attach::factory('image',$item['image'],$params);
                    $item['image_file'] = new Image($item['image']);
                }
                if (!empty($item['redirect'])) {
                    $item['url'] = $item['redirect'];
                }
                $menu[] = $item;
            }
        }
        return $menu;
    }

    private function get_public_sitemap_items($tree)
    {
        $menu = [];
        $settings = Registry::get('settings');
        $params = $settings->getSiteParams();
        foreach ($tree as $item) {
            if (!empty($item['public'])) {
                if (!empty($item['childs'])) {
                    $item['childs'] = $this->get_public_sitemap_items($item['childs']);
                }
                if (!empty($item['image'])) {
                    $item['image_file'] = Attach::factory('image', $item['image'], $params);
                }
                if (!empty($item['alias'])) {
                    $item['url'] = $item['alias'];
                }
                if (!empty($item['redirect'])) {
                    $item['url'] = $item['redirect'];
                }
                $menu[] = $item;
            }
        }
        return $menu;
    }
}