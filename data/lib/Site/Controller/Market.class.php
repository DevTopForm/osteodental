<?php

class Site_Controller_Market extends Site_Controller{

	public function isDispatchable($pathStr){
		$pathStr = $this->removePathPrefix($pathStr);
		return preg_match(
			'/^market$/',
			$pathStr
		);
	}

	public function run(){
		$market = new Market();
		$market->display();
	}
}