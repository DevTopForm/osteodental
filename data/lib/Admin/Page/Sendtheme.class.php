<?php

class Admin_Page_Sendtheme extends Admin_Page_LAVED{

	protected $localTpl = 'content/sendtheme.tpl';
	protected $action = 'sendtheme';

  const STATE_LIST   = 'list';
	const STATE_EDIT   = 'edit';
  const STATE_ADD   = 'add';

  protected function setItemFields(){
		$this->item->title = strip_tags(Query::$post['title']);
		$this->item->public	= empty(Query::$post['public']) ? 0 : 1;
	}

  protected function getStateRegexps(){
    return array(
      self::STATE_LIST => '/^list$/i',
      self::STATE_EDIT => '/^edit\/\d+$/i',
      self::STATE_ADD => '/^add$/i',
    );
  }

	protected function executeRequestProcessing(){
		//parent::executeRequestProcessing();
		if ($this->state == self::STATE_LIST) {
			$this->updateList();
		} elseif ($this->state == self::STATE_EDIT || $this->state == self::STATE_ADD) {
			$this->editItem();
		}
	}

	protected function updateList(){
		if (isset(Query::$post['remove']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Sendtheme($item_id);
					$comment->delete();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
		if (isset(Query::$post['public']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Sendtheme($item_id);
					$comment->public = 1;
					$comment->save();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
	}

	protected function getItem(){
		return new Item_Sendtheme($this->extractItemId());
	}

	protected function getItemsList(){
		return Item_Sendtheme::getList($this->getParameters(),20);
	}

  protected function prepareList($list){
    return $list;
  }

  protected function parseStateEdit(){
		$tpl = $this->getItemsTpl();
		$tpl->assign('item',$this->item);
		return $tpl->fetch($this->localTpl);
	}
}
