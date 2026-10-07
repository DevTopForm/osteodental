<?php

namespace App\Module;

use App\File;
use App\Form\Complex;
use App\Image;
use App\Node;
use App\Query;
use App\Structure;

class Services extends Item
{

    protected function prepareMainContent()
    {
        $this->params = $this->node->getParams(0);
        $items = $this->node->getItems()->getItems();
        $item = array_shift($items);
        $doptext = '';

        $h1 = strip_tags($this->node->h1 ?: $item->title ?: $this->node->title);

        $this->node->meta_title = !empty($this->node->meta_title) ? $this->node->meta_title : sprintf('%s – цена в стоматологии Osteo Dental в Санкт-Петербурге', $h1);
        $this->node->meta_keywords = !empty($this->node->meta_keywords) ? $this->node->meta_keywords : $item->meta_keywords;
        $this->node->meta_description = !empty($this->node->meta_description) ? $this->node->meta_description : sprintf('%s в цифровой стоматологии Osteo Dental в СПб. Современные протоколы, опытные врачи, планирование результата до начала лечения. Запишитесь на консультацию', $h1);

        foreach (['image', 'video_cover', 'video_2_cover', 'under_video_image', 'under_video_2_image', 'head_1', 'head_2', 'head_3', 'text_2_image'] as $image) {
            if (!empty($item->$image) && !is_object($item->$image)) {
                $item->$image = new Image($item->$image);
            }
        }

        foreach (['video', 'video_2'] as $file) {
            if (!empty($item->$file) && !is_object($item->$file)) {
                $item->$file = new File($item->$file);
            }
        }



        foreach (['banner_list', 'numbers'] as $string) {
            if (!empty($item->$string)) {
                $item->$string = unserialize($item->$string);
            }
        }

        $item->anchors = [
            'service' => 'Об услуге',
            'prices' => 'Цена'
        ];

        $item->banner_staff = self::getStaffByIDs($item->banner_staff ?: '');
        $item->equipment = self::getEquipmentByIDs($item->equipment ?: '');
        $item->prices = self::getPricesByIDs($item->prices ?: '');
        $item->prices_list = self::getPricesByIDs($item->prices_list ?: '');
        $item->results = self::getResultsByIDs($item->results ?: '');
        $item->stocks = self::getStocksByIDs($item->stocks ?: '');
        $item->services = self::getServicesByIDs($item->services ?: '');
        $item->advantages = ($item->advantages) ? Complex::getDisplayValue($item->advantages) : [];
        $item->advantages_2 = !empty($item->advantages_2) ? Complex::getDisplayValue($item->advantages_2) : [];
        $item->bottom_slider = !empty($item->bottom_slider) ? Complex::getDisplayValue($item->bottom_slider) : [];
        $item->faq = ($item->faq) ? Complex::getDisplayValue($item->faq) : [];

        $item->children = self::getServicesByParent($item->node->id);

        if(!empty($item->results)){
            $item->anchors['results'] = 'Результаты';
        }

        if(!empty($item->stocks)){
            $item->anchors['stocks'] = 'Акции';
        }

        if(!empty($item->faq)){
            $item->anchors['faq'] = 'Вопросы';
        }

        if (!empty(trim($item->schema_price))) {
            $this->data['ld_json'] = json_encode([
                "@context" => "https://schema.org",
                "@type" => "Product",
                "name" => $this->node->title,
                "description" => strip_tags($item->text),
                "category" => "Красота и здоровье",
                "brand" => [
                    "@type" => "Brand",
                    "name" => "OSTEO Dental"
                ],
                "offers" => [
                    "@type" => "Offer",
                    "price" => trim($item->schema_price),
                    "priceCurrency" => "RUB",
                    "availability" => "https://schema.org/InStock"
                ]
            ], JSON_UNESCAPED_UNICODE);
        }

        if(!empty($item->faq)) {
            $this->data['ld_json_faq'] =  [
                "@context" => "https://schema.org",
                "@type" => "FAQPage",
                "mainEntity" => []
            ];
            foreach ($item->faq as $faq) {
                $this->data['ld_json_faq']["mainEntity"][] = [
                    "@type" => "Question",
                    "name" => $faq['title'],
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => strip_tags($faq['answer'])
                    ]
                ];
            }

            $this->data['ld_json_faq'] = json_encode($this->data['ld_json_faq'], JSON_UNESCAPED_UNICODE);
        }

        $this->data['content'] = $item;
    }

    public static function prepareItem($node)
    {
        Node\Item::$itemsTable = 'content_' . $node->type->type;
        $node->item = Node\Item::getByKey('node', $node->id);

        return $node;
    }
}