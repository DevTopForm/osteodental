<?php
namespace App\Site;

use App\Registry;
use App\Searcher;
use App\Setting as GlobalSetting;
use App\Site\Setting\Field;

class Setting extends GlobalSetting {
	
	protected $fields_table = 'site_params_fields';
	protected $options_table = 'site_params_fields_options';

	public static function getInstance(){
		if (self::$instance === null){
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function getAllSettings(){
	}

	public function get($name){
		return '';
	}

	public function set($name,$value){
		return '';
	}


	private function getSelectTemplate(){
		return sprintf(
			"SELECT * FROM `%s` WHERE `id`='%s'",
			$this->table,
			$this->id
		);
	}

	protected static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}
	
	public function getItemsList($table,$parameters = array()){
		$searcher = new Searcher();
		$searcher->setTable($table);
		$searcher->noPager();
		if (empty($parameters['sorters'])) {
			$parameters['sorters'] = array('weight ASC');
		}
		$searcher->applySearchParameters($parameters);
		$recordSet = $searcher->search();
		return $recordSet->getItems();
	}

	public function getFields($params=array()){
		$fields_data = $this->getItemsList($this->fields_table, $params);
		$fields = array();
		foreach ($fields_data as $field){
			$fields[] = new Field($field);
		}
		return $fields;
	}


	public function addField($data){
		$this->db = Registry::get('db');
		$insert = $this->db->sql->insert();
		$insert->into($this->fields_table);
		$insert->columns(array_keys($data));
		$insert->values($data);
		return $this->db->query($this->db->sql->buildSqlString($insert), $this->db::QUERY_MODE_EXECUTE);

	}

	public function editField($id, $data){
		$db = Registry::get('db');
		$update = $db->sql->update();
		$update->table($this->table);
		$update->set($data);
		$update->where('id='.$this->id);
		return $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
		//return $this->db->update($this->fields_table,$data, '`id`='.$id);
	}

	public function removeField($id){
		$db = Registry::get('db');
		$delete = $db->sql->delete();
		$delete->from($this->fields_table);
		$delete->where('id='.$id);
		return $db->query($db->sql->buildSqlString($delete), $db::QUERY_MODE_EXECUTE);
		//return $this->db->delete($this->fields_table,'`id`='.$id);
	}
}
?>
