<?php

class Site_Controller_Banner extends Site_Controller{

	public function isDispatchable($pathStr){
		$pathStr = $this->removePathPrefix($pathStr);
		return preg_match(
			'/^banner$/',
			$pathStr
		);
	}

	public function run(){
		if (!empty(Query::$get['id'])) {
			$item = new Node_Item('content_banners',(int) Query::$get['id']);
			if (!empty($item->id)){
				$item->simpleUpdate('clicks',++$item->clicks);
				if (!empty($item->link)){
					Utils::redirect($item->link);
				} else {
					Utils::redirect('/');
				}
			}
		} else {
			throw new exception('Banner not found');
		}
	}
}