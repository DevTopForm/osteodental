<?php

namespace App;

class Area extends Model{

	protected $table = 'areas';
	protected $isCachable = true;
	public string $alias;
	public string $title;

	public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	protected function getData(){
		return array(
			'title' 	=> $this->title,
			'alias' 	=> $this->alias,
			'main' 		=> empty($this->main) ? 0 : 1,
			'blocked' 	=> empty($this->blocked) ? 0 : 1,
		);		
	}
}
?>
