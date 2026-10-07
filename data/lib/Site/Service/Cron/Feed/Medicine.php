<?php

namespace App\Site\Service\Cron\Feed;

use App\Module\Staff;
use App\Node;
use App\Registry;
use App\Site\Field\Item;
use App\Site\Service\Cron;
use App\Template;

class Medicine extends Cron
{

    protected $staff = [];
    public function __construct() {
        $settings = Registry::get('settings');
        $this->params = $settings->getSiteParams();
        $this->site_url = 'https://' .$_SERVER['SERVER_NAME'];
    }
    
    public function run() {
        header('Content-type: text/xml; charset=utf-8');
        $template = new Template();
        $template->assign('feed', $this);
        $template->assign('services', $this->getServices());
        $template->assign('staff', $this->staff);
        $xml = $template->fetch('feed/medicine.tpl');
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/upload/feed.xml', $xml);
    }

    protected function getServices() {
        $nodes = Node::getList([
            'filters' => [
                'public = 1',
                'type LIKE "services"'
            ]
        ])->getItems();

        $nodes = array_map([self::class, 'prepareNode'], $nodes);

        $staff = [];
        foreach ($nodes as $node) {
            $staff = array_merge($staff, $node->item->staff);
        }

        foreach ($staff as $staff_item){
            if(empty($this->staff[$staff_item->id])){
                $staff_item->title = explode(' ',  $staff_item->title);
                $staff_item->experience = preg_replace('/[^0-9]/', '', $staff_item->experience);
                $this->staff[$staff_item->id] = $staff_item;
            }
        }

        return $nodes;
    }

    protected static function prepareNode($node) {
        Node\Item::$itemsTable = 'content_services';
        $node->item = Node\Item::getByKey('node', $node->id);
        $node->item->price = str_replace(' ', '', $node->item->price);
        preg_match('/\d+/', $node->item->price, $match);
        $node->item->price = $match[0];
        Node\Item::$itemsTable = 'content_staff';
        $node->item->staff = Node\Item::getList([
            'filters' => [
                'public = 1',
                sprintf('id IN (%s)', $node->item->banner_staff)
            ]
        ])->getItems();

        return $node;
    }
}