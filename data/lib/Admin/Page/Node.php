<?php

namespace App\Admin\Page;

use App\Image;
use App\Item\History as ItemHistory;
use App\Node\Type;
use App\Node\Type\Template as NodeTypeTemplate;
use App\Node\Template as NodeTemplate;
use App\Query;
use App\Registry;
use App\Structure;
use App\Utils;
use App\Node as AppNode;
use App\Item\Favorite as ItemFavorite;

class Node extends LAVED
{

    protected $localTpl = 'content/node.tpl';

    protected $action = 'node';
    const STATE_LOCK = 'lock';
    const STATE_FAVORITE = 'favorite';

    protected function getStateRegexps()
    {
        return [
            self::STATE_ADD => '/^add(\/\d+)?$/i',
            self::STATE_EDIT => '/^edit\/\d+$/i',
            self::STATE_LOCK => '/^lock\/\d+$/i',
            self::STATE_DELETE => '/^delete\/\d+$/i',
            self::STATE_FAVORITE => '/^favorite\/\d+$/i',
        ];
    }

    protected function executeRequestProcessing()
    {
        parent::executeRequestProcessing();
        if ($this->state == self::STATE_LOCK) {
            $this->lockItem();
        } elseif ($this->state == self::STATE_FAVORITE) {
            $this->favoriteItem();
        }
    }

    protected function lockItem()
    {
        $item = $this->getItem();
        if (!empty($item->id) && $this->user->hasAccess('lock')) {
            $item->blocked = empty($item->blocked) ? 1 : 0;
            $item->save();
        }
        Utils::redirectPrevious();
    }

    protected function favoriteItem()
    {
        $item = $this->getItem();
        if (!empty($item->id)) {
            if (isset(Query::$get['value'])) {
                $url = "/adm/content/list/" . $item->id;

                if (Query::$get['value']) {
                    ItemFavorite::add($item->title, $url);
                } else {
                    ItemFavorite::findAndDelete($url);
                }
            }
        }
        Utils::redirectPrevious();
    }

    protected function setItemFields()
    {
        if (empty($this->item->blocked) || $this->user->hasAccess('lock')) {
            $this->item->parent = (int)Query::$post['parent'];
            $this->item->alias = Query::$post['alias'];
            $this->item->redirect = Query::$post['redirect'];
            $this->item->public = empty(Query::$post['public']) ? 0 : 1;
            $this->item->template = new NodeTemplate((int)Query::$post['template']);
            $this->item->content_template = new NodeTypeTemplate((int)Query::$post['content_template']);
            $this->item->type = Type::getByKey('type', Query::$post['type']);
        }
        $this->item->title = Query::$post['title'];
        $this->item->menutitle = empty(Query::$post['menutitle']) ? $this->item->title : Query::$post['menutitle'];
        $this->item->nomenu = empty(Query::$post['nomenu']) ? 0 : 1;
        $this->item->sitemap = empty(Query::$post['sitemap']) ? 0 : 1;
        $this->item->nosearch = empty(Query::$post['nosearch']) ? 0 : 1;
        $this->item->passworded = empty(Query::$post['passworded']) ? 0 : 1;
        $this->item->selection = empty(Query::$post['selection']) ? 0 : 1;

        if (isset(Query::$post['clear_image'])) {
            if (!empty($this->item->image)) {
                $this->item->image->delete();
                $this->item->image = 0;
            }
        }
        if (!empty(Query::$files['image']['tmp_name'])) {
            if (!empty($this->item->image)) {
                $this->item->image->delete();
                $this->item->image = 0;
            }
            $image = new Image(0);
            $image->upload(Query::$files['image'], $this->item->type->type);
            if (!empty($image->id)) {
                $this->item->image = $image;
            } else {
                $this->item->image = 0;
            }
        }

        if ($this->user->role == 'sadmin') {
            $this->item->sadmin = empty(Query::$post['sadmin']) ? 0 : 1;
        }
    }

    protected function getItem()
    {
        $node = new AppNode($this->prepareItemId($this->extractItemId()));
        if ($this->state == self::STATE_ADD) {
            $node->parent = $this->extractItemId();
        }

        return $node;
    }

    protected function prepareItemId($itemId)
    {
        if ($this->state == self::STATE_ADD) {
            return 0;
        } else {
            return $itemId;
        }
    }

    protected function editItem()
    {
        $this->item = $this->getItem();

        if (empty(Query::$post['save'])) {
            return;
        }
        $this->setItemFields();
        if ($this->item->validate()) {
            $this->item->save();
            $this->afterSaveItem();
        }
    }

    protected function getItemsList($archive = 0)
    {
        return AppNode::getList($this->getParameters(), 20);
    }

    protected function getListSorters()
    {
        return [
            'sorter' => 'id ASC'
        ];
    }

    protected function getSpecialEditData()
    {
        $data = [
            'nodes' => Structure::get_instance()->get_tree(),
            'templates' => NodeTemplate::getList()->getItems(),
            'types' => Type::getList(['filters' => ['in_node = 1']])->getItems(),
            'content' => NodeTypeTemplate::getList(['filters' => ['in_block = 0']])->getItems(),
        ];
        return $data;
    }

    protected function afterSaveItem()
    {
        if (!empty(Query::$post['blocks_from'])) {
            $nodeFrom = new AppNode((int)Query::$post['blocks_from']);
            $areas = $nodeFrom->getAreas();
            if (!empty($areas)) {
                foreach ($areas as $copyarea) {
                    $area = clone $copyarea;
                    $area->node = $this->item->id;
                    $area->id = null;
                    $area->save();
                }
            }
        }

        if (!empty($this->item->type->has_items)) {
            $url = "/adm/content/list/" . $this->item->id;
        } elseif(!empty($this->item->type->has_content)) {
            AppNode\Item::$itemsTable = "content_" . $this->item->type->type;
            $item = AppNode\Item::getByKey("node", $this->item->id);
            if (!empty($item->id)) {
                $url = "/adm/content/edit/" . $this->item->id . "/" . $item->id;
            }
        }else{
            $url = "/adm/node/edit/" . $this->item->id;
        }

        ItemHistory::add($this->item->title, $url);
        Utils::redirect($this->pathPrefix . '/edit/' . $this->item->id);
    }

    protected function afterDeleteItem()
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(
            ['redirect' => $this->admPath]
        );
        die();
    }

    protected function parseStateList()
    {
        $tpl = $this->getItemsTpl();
        $items = Structure::getInstance()->getTree();
        if (!is_null($items)) {
            $tpl->assign('list', $items);
        }
        return $tpl->fetch($this->localTpl);
    }

    protected function parseStateView()
    {
        $item = $this->getItem();
        return $tpl->fetch($this->localTpl);
    }


}
