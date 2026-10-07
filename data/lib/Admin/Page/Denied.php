<?php

namespace App\Admin\Page;

class Denied extends Model {
	
	protected $localTpl = 'content/denied.tpl';

	protected function parseContent(){
		$tpl =  $this->getLocalTpl();
		return $tpl->fetch($this->localTpl);
	}
}