<?php

class Admin_Page_Delivery extends Admin_Page_LAVED{

	protected $localTpl = 'content/delivery.tpl';
	protected $action = 'delivery';

	protected function executeRequestProcessing(){
		parent::executeRequestProcessing();
		if ($this->state == self::STATE_LIST) {
			$this->updateList();
		}
	}

	protected function setItemFields(){
		$this->item->title = strip_tags(Query::$post['title']);
		$this->item->text = Query::$post['text'];
		$this->item->price = strip_tags(Query::$post['price']);
		$this->item->active = isset(Query::$post['active']) ? 1 : 0;
	}

	protected function updateList(){
		if (isset(Query::$post['remove']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Order_Delivery($item_id);
					$comment->delete();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
		if (isset(Query::$post['public']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Order_Delivery($item_id);
					$comment->public = 1;
					$comment->save();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
	}

	protected function getListSorters(){
		return array('sorter' => 'ID DESC');
	}

	protected function getItem(){
		return new Item_Order_Delivery($this->extractItemId());
	}

	protected function getItemsList(){
		return Item_Order_Delivery::getList($this->getParameters(),20);
	}
}
