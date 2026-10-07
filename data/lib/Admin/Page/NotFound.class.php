<?php

class Admin_Page_NotFound extends Admin_Page_Abstract{
	
	protected $localTpl = 'content/404.tpl';

	protected function parseContent(){
		$tpl =  $this->getLocalTpl();
		return $tpl->fetch($this->localTpl);
	}
}