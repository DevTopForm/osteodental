<?php

namespace App\Module;

use App\File;
use App\Form\Complex;
use App\Image;
use App\Node\Item;
use App\Item\Infocenter as ItemInfocenter;
use App\Site\Breadcrumb;
use App\Template;

class Infocenter extends Listing
{
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

        $rs = ItemInfocenter::getList($params, NULL);
        $items = [];
        foreach ($rs->getItems() as $item) {
            $item->params = $this->params;
            $items[] = $item->prepareItem($item);
        }
        $rs->setItems($items);
        return $rs;
    }

    protected function parseMainContentItem($item)
    {
        $this->tpl_file = 'module/' . $this->node->getType() . '/item.tpl';
        $item = $this->prepareMainItem($item);


        if (!empty($item->image) && is_object($item->image)){
            $this->node->og_image = $item->image;
        }

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

        $item->date = date('d.m.Y', strtotime($item->date));

        foreach (['text_1', 'text_2'] as $field) {
            if (!empty($item->$field)) {
                preg_match_all('/#([A-Z_]+)_(\d+)#/', $item->$field, $matches, PREG_SET_ORDER);

                foreach ($matches as $match) {
                    Item::$itemsTable = 'content_staff';
                    $doctor = Item::getByKey('id', $match[2]);

                    if (
                        !empty($doctor->image)
                        && !is_object($doctor->image)
                    ) {
                        $doctor->image = new Image($doctor->image);
                    }

                    $template = new Template();
                    $template->assign('content', $doctor);
                    $html = $template->fetch('page/blocks/author.tpl');

                    $item->$field = str_replace($match[0], $html, $item->$field);
                }
            }
        }

        $item->files = ($item->files) ? Complex::getDisplayValue($item->files) : [];
        $item->faq = ($item->faq) ? Complex::getDisplayValue($item->faq) : [];

        $item->cases = self::getResultsByIDs($item->cases ?: '');
        $item->doctors = self::getStaffByIDs($item->doctors ?: '');
        $item->prices = self::getPricesByIDs($item->prices ?: '');

        $item->services = self::getServicesByIDs($item->services ?: '');
        $item->stocks = self::getStocksByIDs($item->stocks ?: 'new');
        $item->articles = self::getArticlesByIDs($item->articles ?: 'new');


        if(!empty($item->sources)){
            $item->sources = unserialize($item->sources);
        }

        $this->data['schema'] = $this->getArticleSchema($item);

        $this->data['content'] = $item;
    }

    public static function prepareItem($item)
    {
        $item = parent::prepareItem($item);
        
        $item->date = date('d.m.Y', strtotime($item->date));
        return $item;
    }

    public static function getArticleSchema($item)
    {
        $date = date(\DateTimeInterface::ATOM, strtotime($item->date));

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'image' => [
                'https://' . $_SERVER['SERVER_NAME'] . (!empty($item->image->id) ? $item->image->getLink() : '/upload/thumbs/default/default/logo_669e3d.png'),
            ],
            'headline' => addslashes($item->h1 ?: $item->title),
            'publisher' => [
                '@type' => 'Organization',
                'name' => addslashes($item->node->params['sitename'])
            ],
            'datePublished' => $date,
            'dateModified' => $date,
            'url' => 'https://' . $_SERVER['SERVER_NAME'] . $item->getUrl(),
        ];

        if (!empty($item->sources)) {
            $schema['citation'] = array_values(array_map(function ($item) {
                return [
                    '@type' => 'CreativeWork',
                    'name' => addslashes($item['value'])
                ];
            }, $item->sources));
        }

        return json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}