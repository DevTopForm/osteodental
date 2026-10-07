<?php

namespace App\Site\Service\Cron;


use App\Node;
use App\Params;
use App\Query;
use App\Registry;
use App\Site\Service\Cron;
use App\Structure;

class Sitemap extends Cron {

    protected $doc;
    protected $urlset;

    public function __construct(){
        $this->doc = new \DOMDocument('1.0', 'utf-8');
        $this->urlset = $this->doc->createElement('urlset');
        $this->urlset->setAttribute('xmlns',"http://www.sitemaps.org/schemas/sitemap/0.9");
    }

    public function run(){
        $tree = Structure::get_instance()->get_tree();
        if(isset(Query::$get['meta']) && !empty(Query::$get['meta'])) {
            echo '<!DOCTYPE html><html lang="ru"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body><table>';
            echo '<tr>
				<td>h1</td>
				<td>title</td>
				<td>description</td>
				<td>key</td>
			</tr>';
            $this->createNodeMetaList($tree);
            echo '</table></body></html>';
        }
        $this->createNodeList($tree);
    }

    private function createNodeMetaList($list){
        foreach ($list as $item){
            $node = new Node($item['id'],$item);
            $nodeTable = $node->getTable();
            if ($node->type->has_items && !in_array($node->type->type,array('feedback','gallery','slider','video','menu','gentypeshipping','gencities','gencountries','country'))) {
                if ($node->id != '200') {
                    echo '<tr>
						<td>'.$node->title.'</td>
						<td>'.($node->meta_title ? $node->meta_title : '').'</td>
						<td>'.($node->meta_description ? $node->meta_description : '').'</td>
						<td>'.($node->meta_keywords ? $node->meta_keywords : '').'</td>
					</tr>';
                    $db = Registry::get('db');
                    //$items = $db->fetchAll('SELECT * FROM `'.$nodeTable.'` WHERE `node`='.$item['id']);
                    $items = $db->query('SELECT * FROM `'.$nodeTable.'` WHERE `node`='.$item['id'], $db::QUERY_MODE_EXECUTE)->toArray();

                    foreach ($items as $itemNode){
                        if ($node->id != '200') {
                            echo '<tr>
								<td>'.$itemNode['title'].'</td>
								<td>'.(isset($itemNode['meta_title']) && !empty($itemNode['meta_title']) ? $itemNode['meta_title'] : '').'</td>
								<td>'.(isset($itemNode['meta_description']) && !empty($itemNode['meta_description']) ? $itemNode['meta_description'] : '').'</td>
								<td>'.(isset($itemNode['meta_keywords']) && !empty($itemNode['meta_keywords']) ? $itemNode['meta_keywords'] : '').'</td>
							</tr>';
                        }
                    }
                }
            } else {
                echo '<tr>
					<td>'.$node->title.'</td>
					<td>'.($node->meta_title ? $node->meta_title : '').'</td>
					<td>'.($node->meta_description ? $node->meta_description : '').'</td>
					<td>'.($node->meta_keywords ? $node->meta_keywords : '').'</td>
				</tr>';
            }

            if (!empty($item['childs'])){
                $this->createNodeMetaList($item['childs']);
            }
        }
    }

    private function createNodeList($list){
        $count = 0;
        $page_num = 1;
        $step = 5000;
        foreach ($list as $listItem){
            $node = new Node($listItem['id'],$listItem);
            $nodeUrl = $node->getUrl();
            $nodeSitemap = $node->sitemap;
            $nodePriority = $node->priority_node;
            $elementPriority = $node->priority_element;
            $nodeChangefreq = $node->changefreq_node;
            $elementChangefreq = $node->changefreq_element;
            $nodePublic = $node->public;
            $nodeTable = $node->getTable();
            if($node->type->has_items && !in_array($node->type->type,array('feedback', 'gallery', 'questions', 'menu', 'reviews')) && $node->public){
                $db = Registry::get('db');
                //$items = $db->fetchAll('SELECT * FROM `'.$nodeTable.'` WHERE `node`='.$listItem['id']);
                $items = $db->query('SELECT * FROM `'.$nodeTable.'` WHERE `node`='.$listItem['id'], $db::QUERY_MODE_EXECUTE)->toArray();

            } else {
                $items = array();
            }
            unset($node);
            if (empty($nodeSitemap)){
                continue;
            }
            if (empty($nodePublic)){
                continue;
            }
            $this->createElement($nodeUrl,$nodeChangefreq, $nodePriority);
            $count++;
            if($count==$step){
                $this->doc->appendChild($this->urlset);
                $this->doc->save('sitemap.xml');
                $page_num++;
                $count = 0;
                $this->urlset = null;
                $this->doc = new \DOMDocument('1.0', 'utf-8');
                $this->urlset = $this->doc->createElement('urlset');
                $this->urlset->setAttribute('xmlns',"http://www.sitemaps.org/schemas/sitemap/0.9");
            }
            if (!empty($items)) {
                foreach ($items as $item){
                    if(!empty($item['alias'])){
                        $this->createElement($nodeUrl.'/'.$item['alias'],$elementChangefreq, $elementPriority);
                    } else {
                        $this->createElement($nodeUrl.'?id='.$item['id'],$elementChangefreq, $elementPriority);
                    }
                    $count++;
                    if($count==$step){
                        $this->doc->appendChild($this->urlset);
                        $this->doc->save('sitemap.xml');
                        $page_num++;
                        $count = 0;
                        $this->urlset = null;
                        $this->doc = new \DOMDocument('1.0', 'utf-8');
                        $this->urlset = $this->doc->createElement('urlset');
                        $this->urlset->setAttribute('xmlns',"http://www.sitemaps.org/schemas/sitemap/0.9");
                    }
                }
                unset($items);
            }
            if (!empty($listItem['childs'])){
                $this->createNodeList($listItem['childs']);
            }
        }
        if($count<$step && $count!=0){
            $this->doc->appendChild($this->urlset);
            $this->doc->save('sitemap.xml');
        }
    }

    private function createElement($loc, $changefreq, $priority){
        $level = explode('/', $loc);

        if(empty($priority)) {
            if (empty($level[4])) {
                $priority = 0.6;
            }
            if (empty($level[3])) {
                $priority = 0.7;
            }
            if (empty($level[2])) {
                $priority = 0.8;
            }
            if ($level[1] == 'informaciya') {
                $priority = 0.5;
            }
            if ($loc == '/main') {
                $priority = 1;
            }

            if(empty($priority)){
                $priority = '0.5';
            }

            if(empty($changefreq)){
                $changefreq = 'weekly';
            }
        }

        if ($loc == '/main') {
            $loc = '/';
        }

        if($level)

            $url = $this->doc->createElement('url');
        $url->appendChild($this->doc->createElement('loc','https://'.Params::$params['public']['site']['host'].$loc));
        $url->appendChild($this->doc->createElement('changefreq',$changefreq));
        $url->appendChild($this->doc->createElement('priority',$priority));
        $this->urlset->appendChild($url);
    }
}

?>