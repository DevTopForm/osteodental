<?php

namespace App\Module;

use App\File;
use App\Form\Complex;
use App\Image;
use App\Site\Breadcrumb;

class Staff extends Listing
{

    public static function prepareItem($item)
    {
        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        $item->numbers = !empty($item->numbers) ? Complex::getDisplayValue($item->numbers) : [];

        return $item;
    }

    protected function prepareMainItem($item)
    {
        $item = static::prepareItem($item);


        if (!empty($item->image) && !is_object($item->image)) {
            $item->image = new Image($item->image);
        }

        $item->certificates = !empty($item->certificates) ? Complex::getDisplayValue($item->certificates) : [];
        $item->video = !empty($item->video) && !is_object($item->video) ? new File($item->video) : $item->video;
        $item->video_cover = !empty($item->video_cover) && !is_object($item->video_cover) ? new Image($item->video_cover) : $item->video_cover;

        $item->results = Results::getResultsByStaffID($item->id);
        $item->prices = self::getPricesByIDs($item->prices ?: '');

        $this->data['ld_json'] = json_encode([
            "@context" => "https://schema.org",
            "@type" => "Physician",
            "@id" => "https://" . $_SERVER['SERVER_NAME'] . $item->getUrl(),
            "name" => $item->title,
//            "alternateName" => "Доктор Иванов",
            "image" => $item->image->id ? $item->image->getLink() : null,
            "description" => $item->position,
            "telephone" => $this->params['phone'],
            "email" => $this->params['email'],
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => str_replace('Санкт-Петербург, ', '', $this->params['address']),
                "addressLocality" => "Санкт-Петербург",
//                "postalCode" => "101000",
                "addressCountry" => "RU"
            ],
            "makesOffer" => !empty($item->prices) ? array_map(function($price){
                return  [
                    "@type" => "Offer",
                    "name" => $price->title,
                    "price" => preg_replace('/[^0-9]/', '', $price->price),
                    "priceCurrency" => "RUB"
                ];
            }, $item->prices) : []
//            "medicalSpecialty" => "Surgical",
//            "affiliation" => [
//                "@type" => "MedicalOrganization",
//                "name" => $this->params['sitename'],
//                "url" => "https://" . $_SERVER['SERVER_NAME']
//            ],
//            "openingHours" => "Mo-Fr 09:00-20:00"
        ], JSON_UNESCAPED_UNICODE);

        return $item;
    }

    protected function parseMainContentItem($item)
    {
        $this->tpl_file = 'module/' . $this->node->getType() . '/item.tpl';
        $item = $this->prepareMainItem($item);
        Breadcrumb::getInstance()->setItem($item);
        $this->node->meta_title = empty($item->meta_title) ? sprintf(
            "%s %s %s",
            $item->title,
            '-',
            $this->node->title
        ) : $item->meta_title;
        $this->node->meta_keywords = empty($item->meta_keywords) ? $this->node->meta_keywords : $item->meta_keywords;
        $this->node->meta_description = empty($item->meta_description) ? sprintf(
            '%s – %s в цифровой стоматологии Osteo Dental в СПб. Современные протоколы диагностики и лечения. Запишитесь на консультацию к специалисту.',
            $item->title,
            $item->position,
        ) : $item->meta_description;
        if (!empty($this->params['comments'])) {
            $this->addComment($item);
            $item->comments = $this->getComments($this->node, $item);
        }
        $this->data['content'] = $item;
    }
}