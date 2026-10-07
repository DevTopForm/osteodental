<?php

namespace App\Site\Service\Cron;

use App\Image;
use App\Node;
use App\Registry;
use App\Site\Service\Cron;
use App\Template;

class Doctors extends Cron
{

    public static $type = array('services');
    private $params = array();

    public function __construct()
    {
        $settings = Registry::get('settings');
        $this->params = $this->prepareSettings($settings->getSiteParams());
    }

    public function display()
    {
        header('Content-type: text/xml; charset=utf-8');

        $template = new Template();
        $template->assign('content', $this->getContent());
        $template->assign('time', date('Y-m-d H:i'));
        $template->assign('params', $this->params);
        $template->assign(
            'branches',
            Node::getList([
                'filters' => [
                    'type' => 'type = "services"',
                    'public' => 'public = 1'
                ],
                'sorters' => [
                    'weight' => 'weight ASC'
                ]
            ])->getItems()
        );
        $content = $template->fetch('xml/doctors.tpl');
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/upload/doctors.xml', $content);
        echo $content;
    }

    public function prepareSettings($params)
    {
        if (!empty($params['logo']) && !is_object($params['logo'])) {
            $params['logo'] = new Image($params['logo']);
        }

        return $params;
    }

    public function getContent()
    {
        Node\Item::$itemsTable = "content_staff";
        $items = Node\Item::getList([
            'filters' => [
                'public' => 'public = 1',
                'price_feed > 0'
            ],
            'sorters' => [
                'sorter' => 'sorter ASC'
            ]
        ])->getItems();

        $db = Registry::get('db');
        foreach ($items as &$item) {
            $aliases = array_column(
                $db->query(
                    sprintf(
                    'SELECT `node` FROM `content_services` WHERE %s',
                        sprintf(
                            '`banner_staff` REGEXP "(^%d\,)|(\,%d\,)|(^%d$)|(\,%d$)"',
                            $item->id,
                            $item->id,
                            $item->id,
                            $item->id
                        )
                    ),
                    $db::QUERY_MODE_EXECUTE
                )->toArray(),
                'node'
            );

            if(!empty($aliases)) {
                $aliases = array_column(
                    $db->query(
                        sprintf(
                            'SELECT `alias` FROM `nodes` WHERE `public` = 1 AND %s',
                            sprintf(
                                'id IN (%s)',
                                implode(', ', $aliases)
                            )
                        ),
                        $db::QUERY_MODE_EXECUTE
                    )->toArray(),
                    'alias'
                );
            }


            $item->branches_alias = !empty($aliases) ? implode(',', $aliases) : '';

            if (!empty($item->image) && !is_object($item->image)) {
                $item->image = new Image($item->image);
            }

            $item->tab_4_text = strip_tags($item->position);
            $item->fio = explode(' ', $item->title);
            $item->work_age_number =  preg_replace("/[^0-9]/", "", $item->experience);

        }

        unset($item);
        return $items;
    }
}