<?php

class Admin_Page_Sale extends Admin_Page_LAVED{

	protected $localTpl = 'content/sale.tpl';
	protected $action = 'sale';

	protected function executeRequestProcessing(){
		parent::executeRequestProcessing();
		if ($this->state == self::STATE_LIST) {
			$this->updateList();
		}
	}

	protected function setItemFields(){
		$this->item->summ = strip_tags(Query::$post['summ']);
		$this->item->sale = strip_tags(Query::$post['sale']);
		$this->item->text = strip_tags(Query::$post['text']);
	}

	protected function updateList(){
		if (isset(Query::$post['remove']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Order_Sale($item_id);
					$comment->delete();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
	}

	protected function getListSorters(){
		return array('sorter' => 'ID DESC');
	}

	protected function getItem(){
		return new Item_Order_Sale($this->extractItemId());
	}

	protected function getItemsList(){
		return Item_Order_Sale::getList($this->getParameters(),20);
	}
}
