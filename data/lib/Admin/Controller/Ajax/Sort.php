<?php

namespace App\Admin\Controller\Ajax;

use App\CacheManager;
use App\Item\Widget;
use App\Query;
use App\Node as AppNode;
use App\Node\Type;
use App\Node\Group;
use App\Node\Item as NodeItem;
use App\Node\Field\Item as NodeFieldItem;
use App\Node\Catalog\Field\Item as NodeCatalogFieldItem;
use App\Node\Variant\Field\Item as NodeVariantFieldItem;
use App\Node\Setting\Field\Item as NodeSettingFieldItem;
use App\Site\Setting\Field;
use Exception;

class Sort extends Action
{

    protected $tpl = '';

    public function run(): void
    {
        switch ($this->path[0]) {
            case 'menu':
                $this->sortMenu();
                break;
            case 'module':
                $this->sortModules();
                break;
            case 'nodeparams':
                $this->sortNodeParams();
                break;
            case 'nodefields':
                $this->sortNodeFields();
                break;
            case 'nodegroups':
                $this->sortNodeGroups();
                break;
            case 'item':
                $this->sortItem();
                break;
            case 'settings':
                $this->sortSettingsFields();
                break;
            case 'nodefieldsvariant':
                $this->sortNodeFieldsVariants();
                break;
            case 'widgets':
                $this->sortWidgets();
        }
    }

    protected function sortMenu(): void
    {
        if (!empty(Query::$get['list'])) {
            foreach (Query::$get['list'] as $key => $id) {
                try {
                    $id = (int)$id;
                    if (!empty($id)) {
                        AppNode::simpleSave($id, "weight", (int)$key * 10);
                    }
                } catch (Exception $e) {
                }
            }
        }
        die;
    }

    protected function sortModules(): void
    {
        if (!empty(Query::$get['list'])) {
            foreach (Query::$get['list'] as $key => $id) {
                try {
                    $id = (int)$id;
                    if (!empty($id)) {
                        Type::simpleSave($id, "sorter", (int)$key * 10);
                    }
                } catch (Exception $e) {
                    pre($e->getMessage());
                }
            }
        }
        die;
    }

    protected function sortNodeFields(): void
    {
        if (!empty(Query::$get['list'])) {
            foreach (Query::$get['list'] as $key => $id) {
                try {
                    $id = (int)$id;
                    if (!empty($id)) {
                        if (Query::$get['node']) {
                            NodeCatalogFieldItem::simpleSave($id, "weight", (int)$key * 10);
                        } else {
                            NodeFieldItem::simpleSave($id, "weight", (int)$key * 10);
                        }
                    }
                } catch (Exception $e) {
                    pre($e->getMessage());
                }
            }
        }
        die;
    }

    protected function sortNodeGroups(): void
    {
        if (!empty(Query::$post['list'])) {
            foreach (Query::$post['list'] as $key => $id) {
                try {
                    $id = (int)$id;
                    if (!empty($id)) {
                        Group::simpleSave($id, "weight", (int)$key * 10);
                    }
                } catch (Exception $e) {
                    pre($e->getMessage());
                }
            }
        }
        die;
    }

    protected function sortNodeFieldsVariants(): void
    {
        if (!empty(Query::$post['list'])) {
            foreach (Query::$post['list'] as $key => $id) {
                try {
                    $id = (int)$id;
                    if (!empty($id)) {
                        NodeVariantFieldItem::simpleSave($id, "weight", (int)$key * 10);
                    }
                } catch (Exception $e) {
                    pre($e->getMessage());
                }
            }
        }
        die;
    }

    protected function sortSettingsFields(): void
    {
        if (!empty(Query::$post['list'])) {
            foreach (Query::$post['list'] as $key => $id) {
                try {
                    $id = (int)$id;
                    if (!empty($id)) {
                        $item = new Field([], $id);
                        $item->weight = $key * 10;
                        $item->save();
                    }
                } catch (Exception $e) {
                    pre($e->getMessage());
                }
            }
        }
        die;
    }

    protected function sortNodeParams(): void
    {
        if (!empty(Query::$get['list'])) {
            foreach (Query::$get['list'] as $key => $id) {
                try {
                    $id = (int)$id;
                    if (!empty($id)) {
                        NodeSettingFieldItem::simpleSave($id, "weight", (int)$key * 10);
                    }
                } catch (Exception $e) {
                    pre($e->getMessage());
                }
            }
        }
        die;
    }

    protected function sortItem(): void
    {
        if (!empty(Query::$get['list']) && !empty(Query::$get['node'])) {
            $page = (int)Query::$get['page'];
            $page = ($page > 0) ? $page : 1;
            $perPage = Query::$get['perPage'] ?? 10;
            $node = new AppNode((int)Query::$get['node']);
            NodeItem::$itemsTable = $node->getTable();
            foreach (Query::$get['list'] as $key => $id) {
                $id = (int)$id;
                if (!empty($id)) {
                    if($perPage == 'all'){
                        NodeItem::simpleSave($id, "sorter", ($page - 1) + ($key + 1));

                    }else {
                        NodeItem::simpleSave($id, "sorter", (($page - 1) * $perPage) + ($key + 1));
                    }
                }
            }
            CacheManager::clear_content($node->getType() . '_' . $node->id);
        } elseif (!empty(Query::$get['to']) && !empty(Query::$get['id']) && !empty(Query::$get['node'])) {
            $to = Query::$get['to'];
            $node = new AppNode((int)Query::$get['node']);

            $item = new NodeItem($node->getTable(), (int)Query::$get['id']);
            if (!empty($item->id)) {
                $items = $node->getItems(['sorters' => ['sorter ' . (($to == 'first') ? 'ASC' : 'DESC')]],
                    1)->getItems();
                if (empty($items)) {
                    $new_sorter = 0;
                } else {
                    $sorter = array_shift($items);
                    $new_sorter = $sorter->sorter + (($to == 'first') ? (-1) : 1);
                }
                $item->simpleUpdate("sorter", $new_sorter);
                CacheManager::clear_content($node->getType() . '_' . $node->id);
            }
        }
        die;
    }

    protected function sortWidgets(): void
    {
        if (!empty(Query::$get['list'])) {
            foreach (Query::$get['list'] as $widget_position => $widget_name) {
                $widget = Widget::getByKey('name', $widget_name);
                Widget::simpleSave($widget->id, 'sorter', $widget_position);
            }
        }
        die;
    }
}