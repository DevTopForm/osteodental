<?php

namespace App\Node\Variant;

use App\Attach;
use App\Image;
use App\Message;
use App\Node\Item as NodeItem;
use App\Registry;

class Item extends NodeItem{
	public static $itemsTable = 'content_catalog_variant';
	public $items;
	public $parent;
	protected function prepareData(){
		//$this->node = new Node($this->node);
	}

	/*
	итемы все хранятся в разных таблицах, поэтому при вызове выборки по итемам должно быть установлено статическое свойство itemsTable (таблица из которой берутся данные об итемах), иначе будет Exception
	*/
	public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		if ($name == 'table'){
			if (!empty(static::$itemsTable)){
				return static::$itemsTable;
			}
			throw new \Exception('Empty node items table');
		}
		return $fields[$name];
	}

	public function setItem($item){
		$this->item = $item;
	}

	protected function getData(){
		$item = (empty($this->item->id)) ? 0 :  $this->item->id;

		$data = array(
			'item' => $item
		);

		foreach ($this->nodes_fields as $key => $field){
			$data[$field->name] = $field->getValue();
		}
		return $data;
	}

	public function validate() {
		$valid = true;        
		foreach ($this->nodes_fields as $key => $field){
			$messages = $field->validate();
			if (!empty($messages)){
				$valid = false;
				$this->errors = array_merge($this->errors,$messages);
                //pre($messages, $field->name, $key, $this->id);
			}

			if ($field->name == 'title'){
				if(!$this->checkTitle($field->getValue())){
					$this->errors[] = new Message('{$_LNG_ADM.UNIQUE}', 'error');
					$valid = false;
				}
			}

			$this->nodes_fields[$key] = $field;
		}
		return $valid;
	}

	protected function checkTitle($title){
		$params = [
			'title' => $title,
			'item' => empty($this->item->id) ? 0 : $this->item->id
		];

		if(!empty($this->id)){
			$params['!id'] = (int)$this->id;
		}

		static::$itemsTable = $this->node->getTable().'_variant';
		$exists = static::getByKeys($params);
		if($exists){
			return false;
		}
		return true;
	}

	public function prepareDelete() {
		$fields = $this->node->getVariantFields();
		foreach ($fields as $field){
			$name = $field->name;
			$type = $field->type;
			if ($type == 'multiimage' && !empty($this->$name)){
				$images = explode(';',$this->$name);
				foreach ($images as $image){
					$image = new Image($image);
					$image->delete();
				}
			} elseif (in_array($type,array('image','file','simplefile')) && !empty($this->$name)) {
				$attach = Attach::factory($type,$this->$name);
				$attach->delete();
			}
		}
	}

	public function update(){
		$db = Registry::get('db');
		$update = $db->sql->update();
		$update->table($this->item->node->getTable().'_variant');
		$update->set(array('item' => $this->item->id));
		$update->where('item=0');
		$db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
	}
}
?>
