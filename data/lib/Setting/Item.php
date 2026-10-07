<?php
namespace App\Setting;

use App\Registry;

class Item {
	
	protected $table = 'site_params_values';

	public $id;
	public $name;
	public $value;

	public function __construct($id = 0,$data = array()) {
		if (!empty($id)){
			$db = Registry::get('db');
			$this->id = $id;
			$data = (empty($data)) ? $db->query($this->getSelectTemplate())->execute()->current() : $data;
			if (!empty($data)){
				$this->setData($data);
			} else {
				$this->id = null;
			}
		}
	}

	public function getData(){
		return array(
			'name' => $this->name,
			'value' => $this->value,
		);
	}

	public function setData($data){
		$this->name = $data['name'];
		$this->value = $data['value'];
	}

	protected static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	private function getSelectTemplate(){
		return sprintf("SELECT * FROM `%s` WHERE `id`='%s'",$this->table,$this->id);
	}

	public function save() {
		$data = $this->getData();
		$db = Registry::get('db');
		if (!empty($this->id)){
			$update = $db->sql->update();
			$update->table($this->table);
			$update->set($data);
			$update->where('id='.$this->id);
			$db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
		} else {
			$insert = $db->sql->insert();
			$insert->into($this->table);
			$insert->columns(array_keys($data));
			$insert->values($data);
			$db->query($db->sql->buildSqlString($insert), $db::QUERY_MODE_EXECUTE);
			$this->id = $db->getDriver()->getConnection()->getLastGeneratedValue();
		}
	}


	public static function get($type,$params = array()){
		return self::getDbData($type,self::getVar('table'),__CLASS__,$params);
	}

	protected static function getDbData($type,$table,$className,$params = array()){
		switch ($type){
			case 'item':
				$data = self::execDb($table,$params,'current');
				return empty($data) ? new $className() : new $className($data['id'],$data);
				break;
			case 'list':
				$data = self::execDb($table,$params);
				$list = array();
				if (!empty($data)){
					foreach ($data as $key => $item){
						$list[$item['id']] = new $className($item['id'],$item);
					}
				}
				return $list;
				break;
			case 'assoc':
				$data = self::execDb($table,$params);
				$list = array();
				if (!empty($data)){
					foreach ($data as $key => $item){
						$list[$item['name']] = $item['value'];
					}
				}
				return $list;
				break;
			case 'assoclist':
				$data = self::execDb($table,$params);
				$list = array();
				if (!empty($data)){
					foreach ($data as $key => $item){
						$list[$item['name']] = new $className($item['id'],$item);
					}
				}
				return $list;
				break;
			default: 
				return array();
		}
	}

	protected static function execDb($table,$params,$method = 'toArray'){
		$db = Registry::get('db');
		$select = $db->sql->select()->from($table);
		/*foreach ($params as $key => $value){
			$select->where($key.' = ?', $value);
		}*/
		$select->where($params);
		return $db->query($db->sql->buildSqlString($select), $db::QUERY_MODE_EXECUTE)->$method();
		//return $db->quey($select)->$method();
	}
}
?>
