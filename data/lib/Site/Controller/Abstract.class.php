<?php

class Site_Controller_Abstract extends Site_Controller{

	protected $model = '';
	protected $template = '';

	public function isDispatchable($pathStr){
		return false;
	}

	public function run(){
		$model = $this->model;
		$status = 'error';
		$action = '';
		switch($this->path[1]){
			case 'add':
			$item = new Node_Item('content_catalog',(int) Query::$get['item']);
			if (!empty($item->id)){
				$itemsList = $model::getInstance()->getItems();
				if(empty($itemsList) || !array_key_exists($item->id,$itemsList)){
					$model::getInstance()->addItem($item);
					$status = 'success';
					$action = 'add';
				} else {
					$model::getInstance()->removeItem($item->id);
					$status = 'success';
					$action = 'remove';
				}
			}
			break;
		}
		if($status=='success'){
			$tpl = new Template();
			$tpl->assign('deferrer', $model::getInstance()->getTotal());
		}
		if (!empty(Query::$get['ajax'])){
			$result = array(
				'status' => $status,
				'action' => $action,
				'data' => $model::getInstance()->getTotal(),
				'html' => $tpl->fetch($this->template)
			);
			echo json_encode($result);
			die;
		} else {
			Utils::redirectPrevious();
		}
	}
}
