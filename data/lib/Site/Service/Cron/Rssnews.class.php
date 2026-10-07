<?php
use Laminas\Http\Request;
use Laminas\Http\Client;
class Site_Service_Cron_Rssnews extends Site_Service_Cron {

	public function run(){
		$nodes = Node::getList(array('filters' => array('type="rssnews"')));
		foreach ($nodes as $node){
			$params = $node->getParams();
			$nodeitems = $node->get_items(false)->getItems();

			$nodeitemskeys = array();
			foreach ($nodeitems as $item){
				$nodeitemskeys[] = $item['date'].'_'.$item['title'];
			}
			for ($i = 1; $i <= 3; $i++){
				if (!empty($params['rss_'.$i])){
					list($items,$title) = $this->getRssItems($params['rss_'.$i],$nodeitemskeys);
					$parser = empty($params['rss_parser_'.$i]) ? '' : $params['rss_parser_'.$i];
					$this->addRssItems($items, $node, $title, $parser);
				}
			}
		}
	}

	protected function addRssItems($items,$node, $title, $parser = ''){
		foreach ($items as $item){
			if (!empty($parser)){
				$client = new Client($item['link']);
				$response = $client->send();
				if ($response->isOk() && preg_match(sprintf('/%s/Usi',$parser),$response->getBody(),$matches)) {
					$item['text'] = preg_replace('/<a[^>]*>(.*)<\/a>/Usi','\\1',iconv('WINDOWS-1251', 'UTF-8', $matches[1]));
					$item['text'] .= sprintf('<p>Источник: <a href="%s">%s</a></p>',$item['link'],$title);
				}

			}
			$this->addItem($item,$node);
		}
	}

	public function getRssItems($rss,$keys){
		try {
			$channel = new Zend_Feed_Rss($rss);
			$items = array();
			foreach ($channel as $item) {
				$date = strtotime($item->pubDate());
				$itemkey = $date.'_'.$item->title();
				if (!in_array($itemkey,$keys)){
					$items[] = array(
						'title' => $item->title(),
						'link' => $item->link(),
						'announce' => $item->description(),
						'date' => $date,
					);
					$keys[] = $itemkey;
				}
			}
			return array($items,$channel->title());
		} catch (exception $e){
			return array(array(),'');
		}
	}

	protected function addItem($item,$node){
		$item['node'] = $node->id;
		$item['pub_date'] = $item['date'];
		$db = Registry::get('db');
		$db->insert('content_rssnews',$item);
	}
}
?>
