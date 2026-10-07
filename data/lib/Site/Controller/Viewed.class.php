<?php

class Site_Controller_Viewed extends Site_Controller_Abstract{

	protected $model = 'Site_Viewed';

	public function isDispatchable($pathStr){
		$pathStr = $this->removePathPrefix($pathStr);
		return preg_match(
			'/^viewed\/.*$/',
			$pathStr
		);
	}
}
