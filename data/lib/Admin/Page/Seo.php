<?php

namespace App\Admin\Page;

use App\Query;
use App\Utils;
use App\Node as AppNode;
use App\Item\Seo as ItemSeo;
use App\Item\History as ItemHistory;

class Seo extends LAVED
{
    protected $localTpl = 'content/seo.tpl';
    const STATE_ROBOTS = 'robots';
    const STATE_METRIKA = 'metrika';
    protected $defaultState = 'robots';
    protected $action = "seo";

    protected function getStateRegexps()
    {
        return [
            self::STATE_ROBOTS => '/^robots/i',
            self::STATE_METRIKA => '/^metrika/i',
            self::STATE_EDIT => '/^edit\/\d+$/i',
        ];
    }

    protected function executeRequestProcessing()
    {
        parent::executeRequestProcessing();
        if ($this->state == self::STATE_ROBOTS) {
            $this->editRobots();
        } elseif ($this->state == self::STATE_METRIKA) {
            $this->editMetrik();
        }
    }

    protected function editMetrik()
    {
        $this->action = "metrika";
    }

    protected function editRobots()
    {
        $this->action = "robots";

        if (isset(Query::$post['save']) && !empty(Query::$post['save'])) {
            $this->item = $this->getRobots();
            $order = new ItemSeo($this->item[0]->id);

            $order->data = Query::$post['data'];
            $order->seo_type = 'robots';
            $file = $_SERVER['DOCUMENT_ROOT'] . '/robots.txt';
            $handle = fopen($file, 'w+');
            fwrite($handle, $order->data);
            fclose($handle);
            $order->save();

            ItemHistory::add("SEO", "/adm/seo");
            Utils::redirect($this->pathPrefix);
        }
    }

    protected function getRobots()
    {
        return ItemSeo::getList($this->getParameters(), 50)->getItems();
    }

    private function getYandexCounter()
    {
        $code = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/templates/common/page/blocks/yandex_counter.tpl');
        if (!empty($code)) {
            $code = $this->removeSmartyTags($code);
        }
        if (isset(Query::$post['yandex_code'])) {
            if (!empty(Query::$post['yandex_code'])) {
                $codeInsert = Query::$post['yandex_code'];

                if (strpos($codeInsert, 'https://mc.yandex.ru/metrika/tag.js') === false || strpos(
                        $codeInsert,
                        'https://mc.yandex.ru/watch/'
                    ) === false || strpos($codeInsert, 'ym(') === false) {
                    $codeInsert = '{literal}<div style="display: none">Ошибка! Это не код Yandex metrika!</div>{/literal}';
                } else {
                    if (strpos($codeInsert, '{literal}') === false) {
                        $codeInsert = '{literal}' . $codeInsert;
                    }

                    if (strpos($codeInsert, '{/literal}') === false) {
                        $codeInsert .= '{/literal}';
                    }
                }
                file_put_contents(
                    $_SERVER['DOCUMENT_ROOT'] . '/templates/common/page/blocks/yandex_counter.tpl',
                    $codeInsert
                );
                ItemHistory::add("Метрика", "/adm/seo/metrika");
                $code = $this->removeSmartyTags($codeInsert);
            } else {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/templates/common/page/blocks/yandex_counter.tpl', '');
            }
        }
        return $code;
    }

    private function getGoogleCounter()
    {
        $code = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/templates/common/page/blocks/google_counter.tpl');
        if (!empty($code)) {
            $code = $this->removeSmartyTags($code);
        }
        if (isset(Query::$post['google_code'])) {
            if (!empty(Query::$post['google_code']) && strlen(Query::$post['google_code']) > 5) {
                $codeInsert = Query::$post['google_code'];
                if (strpos($codeInsert, 'function gtag') === false || strpos(
                        $codeInsert,
                        'https://www.googletagmanager.com/gtag/js'
                    ) === false) {
                    $codeInsert = '{literal}<div style="display: none">Ошибка! Это не код Google Analitics!</div>{/literal}';
                } else {
                    if (strpos($codeInsert, '{literal}') === false) {
                        $codeInsert = '{literal}' . $codeInsert;
                    }
                    if (strpos($codeInsert, '{/literal}') === false) {
                        $codeInsert .= '{/literal}';
                    }
                }
                file_put_contents(
                    $_SERVER['DOCUMENT_ROOT'] . '/templates/common/page/blocks/google_counter.tpl',
                    $codeInsert
                );
                $code = $this->removeSmartyTags($codeInsert);
            } else {
                file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/templates/common/page/blocks/google_counter.tpl', '');
            }
        }
        return $code;
    }

    private function removeSmartyTags($code)
    {
        $code = mb_substr($code, 9);
        $length = mb_strlen($code);
        $code = mb_substr($code, 0, $length - 10);
        return $code;
    }

    protected function getListFilters()
    {
        $params = [
            "seo_type='robots'"
        ];

        return $params;
    }

    protected function parseStateRobots()
    {
        $tpl = $this->getItemsTpl();
        $this->item = $this->getRobots();
        $tpl->assign('item', $this->prepareEditItemHtml($this->item[0]));
        return $tpl->fetch($this->localTpl);
    }

    protected function parseStateMetrika()
    {
        $tpl = $this->getItemsTpl();
        $tpl->assign('yandex', $this->getYandexCounter());
        $tpl->assign('google', $this->getGoogleCounter());
        return $tpl->fetch($this->localTpl);
    }

    protected function editItem()
    {
        $this->item = $this->getItem();
        $this->localTpl = 'content/seo_block.tpl';
        if ($this->state == self::STATE_ADD) {
            $this->item->parent = $this->extractItemId();
        }
        if (empty(Query::$post['save'])) {
            return;
        }
        $this->setItemFields();
        if ($this->item->validate()) {
            $this->item->save();
            Utils::redirect($this->pathPrefix . '/' . $this->relativePath);
        }
    }

    protected function getItem()
    {
        return new AppNode($this->extractItemId());
    }

    protected function setItemFields()
    {
        $this->item->redirect = strip_tags(Query::$post['redirect']);
        $this->item->bread = strip_tags(Query::$post['bread']);
        $this->item->noindex = strip_tags(Query::$post['noindex']);
        $this->item->canonical = strip_tags(Query::$post['canonical']);
        $this->item->meta_title = strip_tags(Query::$post['meta_title']);
        $this->item->meta_keywords = strip_tags(Query::$post['meta_keywords']);
        $this->item->meta_description = strip_tags(Query::$post['meta_description']);
        $this->item->priority_node = strip_tags(Query::$post['priority_node']);
        $this->item->priority_element = strip_tags(Query::$post['priority_element']);
        $this->item->changefreq_node = strip_tags(Query::$post['changefreq_node']);
        $this->item->changefreq_element = strip_tags(Query::$post['changefreq_element']);
        $this->item->h1 = strip_tags(Query::$post['h1']);
    }
}