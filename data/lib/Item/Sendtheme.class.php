<?php
class Item_Sendtheme extends Model {

	protected $table = 'item_sendtheme';
	protected $defaultSorter = 'title';
	protected $defaultOrder = 'ASC';

	protected function prepareData(){

	}

	protected function getData(){
		$data = array(
			'title' => empty($this->title) ? '' : $this->title,
			'public' => empty($this->public) ? 0 : 1,
			);
		return $data;
	}

	// возвращает объект RecordSet содежащий выборку из базы в объектах
	public static function getList($parameters = array(),$limiter = null,$class = 'Item_Sendtheme'){
		return parent::getList($parameters,$limiter,$class);
	}

	// возвращает объект RecordSet содежащий выборку из базы
	public static function getListArray($parameters = array(), $limiter = null, $class = 'Item_Sendtheme'){
		return parent::getListArray($parameters,$limiter,$class);
	}

	public static function getByKey($key, $value, $class = 'Item_Sendtheme'){
		return parent::getByKey($key,$value,$class);
	}

	public static function getListByKey($key,$value, $limiter = null,$class = 'Item_Sendtheme'){
		return parent::getListByKey($key,$value, $limiter,$class);
	}

	public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	public function validate() {
		$valid = true;
		if (empty($this->title)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо заполнить поле «Заголовок»', 'error');
		}
		return $valid;
	}

}
?>
