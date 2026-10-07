<?php
/*
LAVED - List/Add/View/Edit/Delete
Страница реализует общую логику обработки и отображения
простых объектов-активных записей, когда работа в административном
интерфейсе представляет из себя просмотр списка таких объектов,
создания новых, редактирования и удаления.

А это очень распространенная задача. Пример - список новостей.
*/

namespace App\Cabinet\Page;

use App\Cabinet\Item;
use App\Control\Element;
use App\Query;
use App\Template;
use App\Utils;
use Exception;
use App\Node\Item as NodeItem;

abstract class LAVED extends Model
{

    protected string $defaultState = 'list';

    const STATE_LIST = 'list';
    const STATE_ADD = 'add';
    const STATE_VIEW = 'view';
    const STATE_EDIT = 'edit';
    const STATE_DELETE = 'delete';

    protected mixed $item = null;
    protected string $localTpl = 'item.tpl';
    protected array $errors = [];
    protected array $filters = [];
    public string $state;

    protected function setItemFields()
    {
    }

    protected function defineState(): void
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

    protected function getStateRegexps(): array
    {
        return [
            self::STATE_LIST => '/^list$/i',
            self::STATE_ADD => '/^add$/i',
            self::STATE_VIEW => '/^view\/\d+$/i',
            self::STATE_EDIT => '/^edit\/\d+$/i',
            self::STATE_DELETE => '/^delete\/\d+$/i',
        ];
    }

    protected function executeRequestProcessing(): void
    {
        if ($this->state == self::STATE_EDIT || $this->state == self::STATE_ADD) {
            $this->editItem();
        }
        if ($this->state == self::STATE_DELETE) {
            $this->deleteItem();
        }
    }

    protected function getItem(): mixed
    {
        return new Item($this->extractItemId());
    }

    protected function extractItemId(): int
    {
        return @intval($this->parts[3]);
    }

    protected function editItem(): void
    {
        $this->item = $this->getItem();
        if (empty(Query::$post['save'])) {
            return;
        }
        $this->setItemFields();
        if ($this->item->validate()) {
            $this->item->save();
            Utils::redirect($this->pathPrefix . '/view/' . $this->item->id);
        }
    }

    protected function deleteItem(): void
    {
        $this->item = $this->getItem();
        if (!empty($this->item->id)) {
            try {
                $this->item->delete();
            } catch (Exception) {
                return;
            }
        }
        Utils::redirect($this->pathPrefix);
    }

    protected function parseContent(): string
    {
        $method = sprintf('parseState%s', ucfirst($this->state));
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return sprintf('Пока не определено отображение для состояния: %s. Метод: %s', $this->state, $method);
    }

    /**
     * @throws \Smarty\Exception
     */
    protected function parseStateList(): string
    {
        $tpl = $this->getItemsTpl();
        $items = $this->prepareList($this->getItemsList());
        if (!is_null($items)) {
            $tpl->assign('list', $items->getItems());
            $tpl->assign('total', $items->getTotal());
            $tpl->assign('filters', $this->getFiltersHtml());
            $items->getPager()->bindWith($this->filters);
            $tpl->assign('pager', $items->getPager()->getHTML());
            $tpl->assign('perpage', $items->getPager()->getPerPage());
        }
        return $tpl->fetch($this->localTpl);
    }

    protected function getItemsList()
    {
        return NodeItem::getList($this->getParameters(), 20);
    }

    protected function prepareList($list)
    {
        return $list;
    }

    protected function getListFilters(): array
    {
        return [];
    }

    protected function getListSorters(): array
    {
        return [];
    }

    protected function getParameters(): array
    {
        $parameters = [
            'filters' => $this->getListFilters(),
            'sorters' => $this->getListSorters(),
        ];
        $this->filters = $this->prepareFilters($parameters);
        return $parameters;
    }

    protected function prepareFilters($parameters = []): array
    {
        $filters = [];
        foreach ($parameters as $group) {
            foreach ($group as $key => $filter) {
                $filters[$key] = $filter;
            }
        }
        foreach ($filters as $filter) {
            foreach ($filters as $bindFilter) {
                if ($filter instanceof Element && $filter !== $bindFilter) {
                    $filter->bindWith($bindFilter);
                }
            }
        }
        return $filters;
    }

    protected function getFiltersHtml(): array
    {
        $filters = [];
        foreach ($this->filters as $key => $filter) {
            if ($filter instanceof Element) {
                $filters[$key] = $filter->getHTML();
            } else {
                $filters[$key] = $filter;
            }
        }
        return $filters;
    }

    protected function getStateFilters(): array
    {
        return match ($this->state) {
            self::STATE_LIST => $this->filters,
            default => [],
        };
    }

    /**
     * @throws \Smarty\Exception
     */
    protected function parseStateAdd(): string
    {
        return $this->parseStateEdit();
    }

    /**
     * @throws \Smarty\Exception
     */
    protected function parseStateEdit(): string
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->prepareEditItemHtml($this->item));
        $tpl->assign('data', $this->getSpecialEditData());
        $tpl->assign('errors', $this->item->errors);
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws \Smarty\Exception
     */
    protected function parseStateView(): string
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

    protected function getSpecialEditData(): array
    {
        return [];
    }

    /**
     * @throws \Smarty\Exception
     */
    protected function parseStateDelete(): string
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

    protected function getItemsTpl(): Template
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('state', $this->state);
        $tpl->assign('user', $this->user);
        return $tpl;
    }
}
