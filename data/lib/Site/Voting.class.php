<?php

class Site_Voting extends Site_Abstract{

	protected function getData(){
		$this->data = empty($_COOKIE) ? array() : $_COOKIE;
		return $this->data;
	}

	protected function saveData(){
    if(!empty($this->sesskey)){
      setcookie($this->sesskey,true,time()+60*60*24*365,'/');
		  $_COOKIE[$this->sesskey] = $this->data;
    }
	}

	public function addItem($item, $count = 1){
    $this->sesskey = $this->getItemKey($item);
		if (empty($this->data[$this->sesskey])) {
      $resultItem = new Item_Result();
      $resultItem->item = $item->id;
      $resultItem->variant = ($item->type == 'single') ? (int)$item->answer : implode(';', $item->answer);
      $resultItem->ip = $_SERVER['REMOTE_ADDR'];
      $resultItem->date = time();
      $resultItem->save();
			$this->data[$this->sesskey] = array(
				'item'    => $resultItem->id,
				'variant' => $resultItem->variant,
        'ip'      => $resultItem->ip,
  			'date'    => $resultItem->date,
			);
		}
		$this->saveData();
	}

	public function getItemKey($item){
		return sprintf('voted-%s',$item->id);
	}

	public function removeItem($item){
    $this->sesskey = $this->getItemKey($item);
    if(isset($this->data[$this->sesskey])){
		  unset($this->data[$this->sesskey]);
    }
    $resultItem = Item_Result::getByKeys(array('item' => $item->id, 'ip' => $_SERVER['REMOTE_ADDR']));
    if($resultItem){
      $resultItem->delete();
    }
		$this->saveData();
	}

}
