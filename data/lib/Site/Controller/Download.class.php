<?php

class Site_Controller_Download extends Site_Controller{

	public function isDispatchable($pathStr){
		$pathStr = $this->removePathPrefix($pathStr);
		return preg_match(
			'/^download$/',
			$pathStr
		);
	}

	public function run(){
		if (!empty(Query::$get['file'])) {
			$file = new File(Query::$get['file']);
			if ($file->checkHash(@Query::$get['hash'])){
				$file->download();
			}
		} else {
			throw new exception('File not found');
		}
	}
}