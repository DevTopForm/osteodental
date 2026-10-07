<?php

namespace App\Admin\Page;

use App\Query;
use App\Registry;
use App\Structure;
use App\Utils;
use App\Node\Area as NodeArea;
use App\Node as AppNode;
use App\Node\Type\Template as NodeTypeTemplate;
use App\Area as AppArea;
use App\Node\Setting as NodeSetting;
use App\Node\Setting\Item as NodeSettingItem;

class Area extends NodeLAVED
{

    protected $localTpl = 'content/area.tpl';

    const STATE_COPY = 'copy';
    const STATE_LOCK = 'lock';
    const STATE_PARAMS = 'params';
    const STATE_DELETEALL = 'deleteall';
    const STATE_DELETESUB = 'deletesub';

    protected function getStateRegexps()
    {
        return [
            self::STATE_LIST => '/^list\/\d+$/i',
            self::STATE_LOCK => '/^lock\/\d+\/\d+$/i',
            self::STATE_EDIT => '/^edit\/\d+\/\d+$/i',
            self::STATE_PARAMS => '/^params\/\d+$/i',
            self::STATE_DELETE => '/^delete\/\d+$/i',
            self::STATE_DELETEALL => '/^deleteall\/\d+$/i',
            self::STATE_DELETESUB => '/^deletesub\/\d+$/i',
            self::STATE_COPY => '/^copy\/\d+$/i',
        ];
    }

    protected function getItem()
    {
        if (!empty($this->parts[3]) && !empty($this->parts[4])) {
            $node = new AppNode($this->extractItemId());
            if (empty($node->id)) {
                Utils::redirectPrevious();
            }
            $area = new AppArea(@intval($this->parts[4]));
            if (empty($area->id)) {
                Utils::redirectPrevious();
            }
            return NodeArea::getByNodeArea($node->id, $area->id);
        } else {
            return new NodeArea($this->extractItemId());
        }
    }

    protected function getItemsList($archive = 0)
    {
        return NodeArea::getList($this->getParameters());
    }

    protected function setItemFields()
    {
        $node = new AppNode((int)Query::$post['node_id']);
        $template = new NodeTypeTemplate((int)Query::$post['node_template']);
        $this->item->template = $template->id;
        $this->item->node_id = $node->id;
    }

    protected function executeRequestProcessing()
    {
        parent::executeRequestProcessing();
        if ($this->state == self::STATE_COPY) {
            $this->copyItems();
        }
        if ($this->state == self::STATE_PARAMS) {
            $this->setAreaParams();
        }
        if ($this->state == self::STATE_DELETEALL) {
            $this->deleteAllAreaItems();
        }
        if ($this->state == self::STATE_DELETESUB) {
            $this->deleteSubAreaItems();
        }
        if ($this->state == self::STATE_LOCK) {
            $this->lockItem();
        }
    }

    protected function lockItem()
    {
        $item = new AppArea(@intval($this->parts[4]));
        if (!empty($item->id) && $this->user->hasAccess('lock')) {
            $item->blocked = empty($item->blocked) ? 1 : 0;
            $item->save();
        }
        $node = new AppNode($this->extractItemId());
        if (!empty($node->id)) {
            Utils::redirect($this->pathPrefix . '/list/' . $node->id);
        } else {
            Utils::redirectPrevious();
        }
    }

    protected function deleteAllAreaItems()
    {
        $this->item = $this->getItem();
        if (!empty($this->item->id)) {
            $areas = NodeArea::getListByKey('area', $this->item->area)->getItems();
            foreach ($areas as $area) {
                try {
                    $area->delete();
                } catch (\Exception $e) {
                }
            }
        }
        $this->afterDeleteItem();
    }

    protected function deleteSubAreaItems()
    {
        $this->item = $this->getItem();
        if (!empty($this->item->id)) {
            $childs = Structure::get_instance()->get_tree($this->item->node);
            $this->clearInSubnodes($childs);
        }
        $this->afterDeleteItem();
    }

    protected function setAreaParams()
    {
        $this->item = $this->getItem();
        if (!empty($this->item->id) && !empty(Query::$post['save'])) {
            $node = $this->item->object;
            $area = new AppArea($this->item->area);
            $fields = NodeSetting::getFieldsList(array('type' => $node->getType(), 'local' => 1));
            $values = NodeSettingItem::get('assoclist', array('node' => $node->id, 'area' => 0));
            $values_local = NodeSettingItem::get('assoclist', array('node' => $node->id, 'area' => $area->id));
            $values = array_merge($values, $values_local);
            foreach ($fields as $key => $field) {
                $field->setQueryValue();
                $messages = $field->validate();
                if (!empty($messages)) {
                    $valid = false;
                    $this->errors = array_merge($this->errors, $messages);
                } else {
                    if (isset($values_local[$field->name])) {
                        $value = $values_local[$field->name];
                    } else {
                        $value = new NodeSettingItem();
                        $value->name = $field->name;
                        $value->node = $node->id;
                        $value->type = $node->getType();
                        $value->area = $area->id;
                    }
                    $value->value = $field->getValue();
                    $value->save();
                }
            }
            $settings = Registry::get('settings');
            $settings->update();
        }
        Utils::redirect($this->pathPrefix . '/list/' . $this->item->node);
    }

    protected function copyItems()
    {
        $node = new AppNode($this->extractItemId());
        if (empty($node->id)) {
            Utils::redirectPrevious();
        }
        $from = new AppNode((int)Query::$post['node']);
        if (!empty($from->id)) {
            $areas = $node->getAreas();
            foreach ($areas as $area) {
                $area->delete();
            }
            $areas = $from->getAreas();
            foreach ($areas as $copyarea) {
                if ($copyarea->area != 0) {
                    $area = clone $copyarea;
                    $area->node = $node->id;
                    $area->id = null;
                    $area->save();
                }
            }
        }
        Utils::redirectPrevious();
    }

    protected function afterSaveItem()
    {
        if (!empty(Query::$post['all'])) {
            $childs = Structure::get_instance()->get_tree(0);
            $this->addToSubnodes($childs);
        } elseif (!empty(Query::$post['allsub'])) {
            $childs = Structure::get_instance()->get_tree($this->item->node);
            $this->addToSubnodes($childs);
        }
        Utils::redirect($this->pathPrefix . '/list/' . $this->item->node);
    }

    protected function clearInSubnodes($list)
    {
        foreach ($list as $node) {
            $nodeArea = NodeArea::getByNodeArea($node['id'], $this->item->area);
            if (!empty($nodeArea->id)) {
                $nodeArea->delete();
            }
            if (!empty($node['childs'])) {
                $this->clearInSubnodes($node['childs']);
            }
        }
    }

    protected function addToSubnodes($list)
    {
        foreach ($list as $node) {
            if ($node['id'] != $this->item->node) {
                $nodeArea = NodeArea::getByNodeArea($node['id'], $this->item->area);
                $nodeArea->node_id = $this->item->node_id;
                $nodeArea->template = $this->item->template;
                $nodeArea->save();
            }
            if (!empty($node['childs'])) {
                $this->addToSubnodes($node['childs']);
            }
        }
    }

    protected function afterDeleteItem()
    {
        Utils::redirect($this->pathPrefix . '/list/' . $this->item->node);
    }

    protected function getSpecialListData()
    {
        return array(
            'nodes' => Structure::get_instance()->get_tree(),
        );
    }

    protected function prepareList($rs)
    {
        $list = $rs->getItems();
        $areas = AppArea::getList()->getItems();
        $nodeAreas = array();
        foreach ($list as $area) {
            $nodeAreas[$area->area] = $area;
        }
        $items = array();
        foreach ($areas as $area) {
            $area->data = empty($nodeAreas[$area->id]) ? null : $nodeAreas[$area->id];
            $items[$area->alias] = $area;
        }
        $rs->setItems($items);
        return $rs;
    }
}