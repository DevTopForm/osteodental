<?php

namespace App\Site;

use App\Node\Item;

class Model{

	protected $sesskey = '';
	protected static $instance = null;

	protected $suff = array(
		0 => 'ов',
		1 => '',
		2 => 'а',
		3 => 'а',
		4 => 'а',
		5 => 'ов',
		6 => 'ов',
		7 => 'ов',
		8 => 'ов',
		9 => 'ов'
	);

	public static function getInstance() {
		if (static::$instance === null) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	protected function __construct() {
		$this->getData();
	}

	public function getItems(){
		return $this->data;
	}

	public function getTotal(){
		$data = array('count' => 0, 'summ' => 0, 'items' => array());
		foreach ($this->data as $item){
			$data['count'] += $item->count;
			if(isset($item->price) && !empty($item->price))
				$data['summ'] += $item->count * $item->price;
			if($item->node->type->has_variants){
				$item->variants = $item->getVariants();
			}
			$data['items'][] = $item;
		}
		$data['suff'] = $this->getSuffix($data['count']);
		return $data;
	}

	protected function getSuffix($count){
		switch ($count % 100){
			case 11: case 12: case 13: case 14: return $this->suff[0];
			default: $this->suff[$count % 10];
		}
	}

	protected function getData(){
		$this->data = array();
		if(!empty($_SESSION[$this->sesskey])){
			$data = $_SESSION[$this->sesskey];
			foreach($data as $sessItem) {
				$itemObj = new Item('content_catalog',$sessItem['id']);
				if(!empty($itemObj->id)){
					if($itemObj->node->type->has_variants)
						$itemObj->variants = $itemObj->getVariants();
					$this->data[$itemObj->id] = $itemObj;
					$this->data[$itemObj->id]->count = 1;
				}
			}
		}
		return $this->data;
	}

	protected function saveData(){
		$data = array();
		if(!empty($this->data)){
			foreach($this->data as $item){
				$data[$item->id] = array('id' => $item->id, 'count' => 1);
			}
		}
		$_SESSION[$this->sesskey] = $data;
	}

	public function addItem($item, $count = 1){
		$key = $item->id;
		if (!empty($this->data[$key])){
			$this->data[$key]->count += $count;
		} else {
			$this->data[$key] = $item;
			$this->data[$key]->count = $count;
		}
		$this->saveData();
	}

	public function removeItem($key){
		unset($this->data[$key]);
		$this->saveData();
	}

	public function setCount($key,$count){
		if (empty($count)){
			$this->removeItem($key);
		} elseif (!empty($this->data[$key])) {
			$this->data[$key]->count = $count;
			$this->saveData();
		}
	}

	public function inList($item_id){
		return array_key_exists($item_id, $this->data);

	}

}
