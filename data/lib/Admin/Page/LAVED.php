<?php
/*
LAVED - List/Add/View/Edit/Delete
Страница реализует общую логику обработки и отображения
простых объектов-активных записей, когда работа в адиминистративном
интерфейсе представляет из себя просмотр списка таких объектов,
создания новых, редактирования и удаления.

А это очень распространенная задача. Пример - список новостей.
*/

namespace App\Admin\Page;

use App\Control\Element;
use App\Node\Item;
use App\Query;
use App\Utils;

abstract class LAVED extends Model
{

    protected $defaultState = 'list';

    const STATE_LIST = 'list';
    const STATE_ADD = 'add';
    const STATE_VIEW = 'view';
    const STATE_EDIT = 'edit';
    const STATE_DELETE = 'delete';
    const STATE_PUBLIC = 'public';
    const STATE_IS_SHOW = 'is_show';
    const STATE_SPAM = 'spam';
    const STATE_IMAGES = 'images';

    protected $item = null;
    protected $localTpl = 'item.tpl';
    protected $errors = [];
    protected $filters = [];

    protected function setItemFields()
    {
    }

    protected function defineState()
    {
        if (empty($this->relativePath)) {
            $this->state = $this->defaultState;
            return;
        }
        foreach ($this->getStateRegexps() as $state => $regexp) {
            if (preg_match($regexp, $this->relativePath)) {
                $this->state = $state;
                return;
            }
        }
        $this->state = self::STATE_ERROR;
    }

    protected function getStateRegexps()
    {
        return [
            self::STATE_LIST => '/^list$/i',
            self::STATE_ADD => '/^add$/i',
            self::STATE_VIEW => '/^view\/\d+$/i',
            self::STATE_EDIT => '/^edit\/\d+$/i',
            self::STATE_DELETE => '/^delete\/\d+$/i',
            self::STATE_PUBLIC => '/^public\/\d+$/i',
            self::STATE_IS_SHOW => '/^is_show\/\d+$/i',
            self::STATE_SPAM => '/^spam\/\d+$/i',
        ];
    }

    protected function executeRequestProcessing()
    {
        if ($this->state == self::STATE_EDIT || $this->state == self::STATE_ADD) {
            $this->editItem();
        }
        if ($this->state == self::STATE_DELETE) {
            $this->deleteItem();
        }
        if ($this->state == self::STATE_PUBLIC) {
            $this->publicItem();
        }

        if ($this->state == self::STATE_SPAM) {
            $this->spamItem();
        }

        if ($this->state == self::STATE_IS_SHOW) {
            $this->isShowItem();
        }
    }

    protected function getItem()
    {
        return new Item($this->extractItemId());
    }

    protected function extractItemId()
    {
        return @intval($this->parts[3]);
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

    protected function deleteItem()
    {
        $this->item = $this->getItem();
        if (!empty($this->item->id)) {
            try {
                $this->item->delete();
            } catch (\Exception $e) {
                return;
            }
        }
        $this->afterDeleteItem();
    }

    protected function publicItem()
    {
        $item = $this->getItem();
        if (!empty($item->id)) {
            $item->public = empty($item->public) ? 1 : 0;
            $item->save();
        }
        $this->afterPublicItem();
    }

    protected function isShowItem()
    {
        $item = $this->getItem();
        if (!empty($item->id)) {
            $item->is_show = empty($item->is_show) ? 1 : 0;
            $item->save();
        }

        Utils::redirect(SYS_ADMIN_PATH_PREFIX);
    }

    protected function spamItem()
    {
        $item = $this->getItem();
        if (!empty($item->id)) {
            $item->spam = empty($item->spam) ? 1 : 0;
            $item->save();
        }
        $this->afterPublicItem();
    }

    protected function afterSaveItem()
    {
        Utils::redirect($this->pathPrefix);
    }

    protected function afterDeleteItem()
    {
        Utils::redirect($this->pathPrefix);
    }

    protected function afterPublicItem()
    {
        Utils::redirect($this->pathPrefix);
    }

    protected function parseContent()
    {
        $method = sprintf('parseState%s', ucfirst($this->state));
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return sprintf('Пока не определено отображение для состояния: %s. Метод: %s', $this->state, $method);
    }

    protected function parseStateList()
    {
        $tpl = $this->getItemsTpl();
        $items = $this->prepareList($this->getItemsList());
        if (!is_null($items)) {
            $tpl->assign('list', $items->getItems());
            $tpl->assign('total', $items->getTotal());
            $tpl->assign('filters', $this->getFiltersHtml());
            $items->getPager()->bindWith($this->filters);
            $tpl->assign('pager', $items->getPager()->getHTML(true));
            $tpl->assign('perpage', $items->getPager()->getPerPage());
        }
        $tpl->assign('data', $this->getSpecialListData());
        return $tpl->fetch($this->localTpl);
    }

    protected function getItemsList()
    {
        return Item::getList($this->getParameters(), $this->getLimit());
    }

    protected function prepareList($list)
    {
        return $list;
    }

    protected function getListFilters()
    {
        return [];
    }

    protected function getListSorters()
    {
        return [];
    }

    protected function getParameters()
    {
        $parameters = [
            'filters' => $this->getListFilters(),
            'sorters' => $this->getListSorters(),
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
                    $filters[$key]->bindWith($bindFilter);
                }
            }
        }
        return $filters;
    }

    protected function getFiltersHtml()
    {
        $filters = [];
        foreach ($this->filters as $key => $filter) {
            if ($filter instanceof Element) {
                $filters[$key] = $filter->getHTML(true);
            } else {
                $filters[$key] = $filter;
            }
        }
        return $filters;
    }

    protected function getStateFilters()
    {
        switch ($this->state) {
            case self::STATE_LIST:
                return $this->filters;
                break;
        }
        return [];
    }

    protected function parseStateAdd()
    {
        return $this->parseStateEdit();
    }

    protected function parseStateImages()
    {
        return $this->parseStateEdit();
    }

    protected function parseStateEdit()
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->getItem());
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->item->errors);
        return $tpl->fetch($this->localTpl);
    }

    protected function parseStateView()
    {
        $tpl = $this->getItemsTpl();
        $item = $this->getItem();
        if (!empty($item->id)) {
            $tpl->assign('item', $this->prepareViewItemHtml($item));
        } else {
            Utils::redirect($this->pathPrefix);
        }
        return $tpl->fetch($this->localTpl);
    }

    protected function getSpecialEditData()
    {
        return [];
    }

    protected function getSpecialListData()
    {
        return [];
    }

    protected function parseStateDelete()
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->prepareViewItemHtml($this->item));
        $tpl->assign('errors', $this->item->errors);
        return $tpl->fetch($this->localTpl);
    }

    protected function prepareViewItemHtml($item)
    {
        return $item;
    }

    protected function prepareEditItemHtml($item)
    {
        return $item;
    }

    protected function getItemsTpl()
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('state', $this->state);
        $tpl->assign('user', $this->user);
        return $tpl;
    }


    public function getLimit(): ?int
    {
        $limiter = intval(Query::$get['count']);

        if (empty(Query::$get['count'])) {
            if (!empty($_SESSION['node-items-count'])) {
                $limiter = $_SESSION['node-items-count'];
            } else {
                $limiter = 10;
            }
        }

        if (Query::$get['count'] == 'all') {
            $limiter = null;
        }

        $_SESSION['node-items-count'] = $limiter;

        return $limiter;
    }
}
