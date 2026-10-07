<?php

namespace App\Cabinet\Page;

use App\Item\Order\Status;
use App\Params;
use App\Query;
use App\Registry;
use App\Utils;
use App\Item\Order as OrderItem;
use Smarty\Exception;

class Orders extends LAVED
{

    protected string $localTpl = 'cabinet/orders.tpl';
    protected mixed $item = null;
    protected array $errors = [];
    protected bool $withcounter = true;
    protected string $menuActive = 'orders';

    const STATE_PAY = 'pay';
    const STATE_SUCCESS = 'success';
    const STATE_ERROR = 'error';
    const STATE_GETFILE = 'getfile';

    protected function setItemFields(): void
    {
        $this->item->title = strip_tags(Query::$post['title']);
        if (empty($this->item->id)) {
            $this->item->date = time();
            $this->item->user = $this->user;
        }
    }

    protected function executeRequestProcessing(): void
    {
        if ($this->state == self::STATE_PAY) {
            $this->payItem();
        }
        if ($this->state == self::STATE_SUCCESS) {
            $this->successItem();
        }
        if ($this->state == self::STATE_GETFILE) {
            $this->getFile();
        }
        if ($this->state == self::STATE_ERROR) {
            $this->errorItem();
        }

        parent::executeRequestProcessing();
    }

    protected function getStateRegexps(): array
    {
        $states = parent::getStateRegexps();
        $states[self::STATE_PAY] = '/^pay\/\d+$/i';
        $states[self::STATE_SUCCESS] = '/^success$/i';
        $states[self::STATE_ERROR] = '/^error$/i';
        $states[self::STATE_GETFILE] = '/getfile\/\d+\/\d+$/i';
        return $states;
    }

    protected function errorItem(): void
    {
        if (empty(Query::$post)) {
            Utils::redirect($this->pathPrefix);
        }
        $this->item = new OrderItem(Query::$post['InvId']);
        if (empty($this->item->id)) {
            Utils::redirect($this->pathPrefix);
        }
        $this->item->status = new Status(4);
        $this->item->save();
    }

    protected function successItem(): void
    {
        if (empty(Query::$post)) {
            Utils::redirect($this->pathPrefix);
        }
        $this->item = new OrderItem(Query::$post['InvId']);
        if (empty($this->item->id)) {
            Utils::redirect($this->pathPrefix);
        }
    }

    protected function getFile(): void
    {
        $this->item = $this->getItem();
        $file = @intval($this->parts[4]);
        if (!empty($this->item->files[$file])) {
            $this->item->files[$file]->download();
        }
        Utils::redirect($this->pathPrefix);
    }

    protected function payItem(): void
    {
        $this->item = $this->getItem();
        if (empty($this->item->id)) {
            Utils::redirect($this->pathPrefix);
        }
        if ($this->item->status->id == 5 || $this->item->status->id == 3 || $this->item->status->id == 6) {
            Utils::redirect($this->pathPrefix . '/view/' . $this->item->id);
        }
        switch ($this->item->payment) {
            case 'bill':
                break;
            case 'online':
                $crc = md5(
                    join(":", [
                        Params::$params['merchant']['robokassa']['login'],
                        $this->item->summ,
                        $this->item->id,
                        Params::$params['merchant']['robokassa']['pass_1']
                    ])
                );
                $settings = Registry::get('settings');
                $merchant = [
                    'MrchLogin' => Params::$params['merchant']['robokassa']['login'],
                    'OutSum' => $this->item->summ,
                    'InvId' => $this->item->id,
                    'Email' => $this->user->mailto,
                    'SignatureValue' => $crc,
                    'Desc' => sprintf(
                        "Оплата заказа №%s/%s в интернет-магазине %s ",
                        date('Y-m-d', $this->item->date),
                        $this->item->num,
                        $settings->getSiteParams('sitename')
                    ),
                    'IncCurrLabel' => '',
                    'Culture' => "ru",
                    'Encoding' => "Utf-8"
                ];
                $url = sprintf('%s?%s', Params::$params['merchant']['robokassa']['url'], http_build_query($merchant));
                Utils::redirect($url);
                break;
        }
    }

    protected function getItem(): OrderItem
    {
        $item = new OrderItem($this->extractItemId());
        if (!empty($item->id) && $item->user->id != $this->user->id) {
            Utils::redirect($this->pathPrefix);
        }

        return $item;
    }

    protected function getItemsList()
    {
        return OrderItem::getList($this->getParameters(), 20);
    }

    protected function getListFilters(): array
    {
        return ['user =' . $this->user->id];
    }

    protected function getListSorters(): array
    {
        return ['date DESC'];
    }

    protected function getSpecialEditData(): array
    {
        return [];
    }

    protected function prepareViewItemHtml($item)
    {
        return $item;
    }

    protected function prepareList($list)
    {
        return $list;
    }

    /**
     * @throws Exception
     */
    protected function parseStateSuccess(): string
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->prepareViewItemHtml($this->item));
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws Exception
     */
    protected function parseStateError(): string
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('item', $this->prepareViewItemHtml($this->item));
        return $tpl->fetch($this->localTpl);
    }

    /**
     * @throws Exception
     */
    protected function parseStatePay(): string
    {
        $tpl = $this->getItemsTpl();
        if ($this->item->payment == 'bill') {
            $this->item->ndssumm = 0.18 * $this->item->summ;
            $tpl->assign('item', $this->prepareViewItemHtml($this->item));
        }
        return $tpl->fetch($this->localTpl);
    }
}
