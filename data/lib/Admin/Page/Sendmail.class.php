<?php

class Admin_Page_Sendmail extends Admin_Page_LAVED{

	protected $localTpl = 'content/sendmail.tpl';
	protected $action = 'sendmail';

  const STATE_LIST   = 'list';
	const STATE_EDIT   = 'edit';
  const STATE_ADD   = 'add';

  protected function setItemFields(){
		$this->item->title = strip_tags(Query::$post['title']);
		$this->item->text = Query::$post['text'];
    $this->item->date = Query::$post['date'];
    $this->item->addresses = Query::$post['addresses'];
		$this->item->themes = empty(Query::$post['themes']) ? array() : Query::$post['themes'] ;
    if (!empty(Query::$post['del_files'])){
      if (!empty($this->item->files)){
        $files_ids = array();
        foreach($this->item->files as $file){
          if(!in_array($file,Query::$post['del_files']))
            $files_ids[] = $file;
        }
        $this->item->files = $files_ids;
      }
    }
    if(!empty(Query::$files['files'])){
      foreach(Query::$files['files'] as $uplFile){
        if (!empty($uplFile['tmp_name'])){
          $file = new File();
          $file->upload($uplFile,'subscribe');
          if (!empty($file->id)){
            $this->item->files[] = $file->id;
          }
        }
      }
    }
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
					$comment = new Item_Subscribe($item_id);
					$comment->delete();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
		if (isset(Query::$post['public']) && isset(Query::$post['list'])) {
			foreach (Query::$post['list'] as $item_id => $item) {
				if (isset($item)) {
					$comment = new Item_Subscribe($item_id);
					$comment->public = 1;
					$comment->save();
				}
			}
			Utils::redirect($this->pathPrefix);
		}
	}

	protected function getItem(){
		return new Item_Subscribe($this->extractItemId());
	}

	protected function getItemsList(){
		return Item_Subscribe::getList($this->getParameters(),20);
	}

  protected function prepareList($list){
    if(!empty($list)){
      $prList = array();
      foreach($list->getItems() as $item){
        if(!empty($item->themes)){
          foreach($item->themes as $key => $theme_id){
            $themeItem = Item_Sendtheme::getByKeys(array('id' => $theme_id));
            $item->themes[$key] = $themeItem->title;
          }
          $item->themes = implode(',',$item->themes);
        }
        $prList[] = $item;
      }
      $list->setItems($prList);
    }
    return $list;
  }

  protected function parseStateEdit(){
    if(!empty($this->item->files)){
      foreach($this->item->files as $key => $file){
        $this->item->files[$key] = new File($file);
      }
    }
		$tpl = $this->getItemsTpl();
		$tpl->assign('item',$this->item);
    $tpl->assign('data',$this->getSpecialEditData());
		return $tpl->fetch($this->localTpl);
	}

  protected function getSpecialEditData(){
    $themes = Item_Sendtheme::getList(array('filters' => array('public=1')));
    $data = array(
      'themes' => $themes->getItems(),
      );
    return $data;
	}
}
