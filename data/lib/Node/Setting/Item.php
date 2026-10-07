<?php
namespace App\Node\Setting;

use App\Setting\Item as SettingItem;

class Item extends SettingItem {
	
	protected $table = 'nodes_params_values';

	public $node;
	public $area;

	public function getData(){
		return array(
			'name' => $this->name,
			'value' => $this->value,
			'area' => $this->area,
			'node' => $this->node,
			'type' => $this->type,
		);
	}

	public function setData($data){
		$this->name = $data['name'];
		$this->value = $data['value'];
		$this->area = $data['area'];
		$this->node = $data['node'];
		$this->type = $data['type'];		
	}

	protected static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	public static function get($type,$params = array()){
		return self::getDbData($type,self::getVar('table'),__CLASS__,$params);
	}

}
?>
