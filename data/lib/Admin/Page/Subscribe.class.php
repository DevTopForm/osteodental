<?php

class Admin_Page_Subscribe extends Admin_Page_LAVED{

	protected $localTpl = 'content/subscribe.tpl';
	protected $action = 'subscribe';

	protected function setItemFields(){
		$this->item->title = strip_tags(Query::$post['title']);
		$this->item->email = strip_tags(Query::$post['email']);
		$this->item->theme = Query::$post['theme'];
		$this->item->active	= empty(Query::$post['active']) ? 0 : 1;
	}

	protected function getItem(){
		return new Item_Subscriber($this->extractItemId());
	}

	protected function getItemsList(){
		return Item_Subscriber::getList($this->getParameters());
	}

	protected function getListFilters(){
		return array();
	}

  protected function prepareList($list){
    if(!empty($list)){
      $prList = array();
      Node_Item::$itemsTable = 'content_theme';
      foreach($list->getItems() as $item){
        if(!empty($item->theme)){
          foreach($item->theme as $key => $theme_id){
            $themeItem = Node_Item::getByKeys(array('id' => $theme_id));
            $item->theme[$key] = $themeItem->title;
          }
          $item->theme = implode(',',$item->theme);
        }
        $prList[] = $item;
      }
      $list->setItems($prList);
    }
    return $list;
  }

	protected function getSpecialEditData(){
    Node_Item::$itemsTable = 'content_theme';
    $theme = Node_Item::getList(array('filters' => array(sprintf('node=312','public=1'))));
    $data = array(
      'theme' => $theme->getItems(),
      );
    return $data;
	}
}
