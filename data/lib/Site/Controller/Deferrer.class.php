<?php

class Site_Controller_Deferrer extends Site_Controller_Abstract{

	protected $model = 'Site_Deferrer';
	protected $template = 'module/deferrer/items.tpl';

	public function isDispatchable($pathStr){
		$pathStr = $this->removePathPrefix($pathStr);
		return preg_match(
			'/^deferrer\/.*$/',
			$pathStr
		);
	}
}
