<?php

namespace App\Admin;

class Controller{

	protected $path;

	public function setPath($pathStr){
		$this->path = explode('/', $pathStr);
	}

	public function isDispatchable($pathStr){
		return false;
	}

	public function run(){
	}

	protected function removePathPrefix($pathStr){
		$prefix = trim(SYS_ADMIN_PATH_PREFIX, '/');
		return trim(substr($pathStr, strlen($prefix)), '/');
	}

}