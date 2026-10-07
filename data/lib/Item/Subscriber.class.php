<?php
class Item_Subscriber extends Model {

	protected $table = 'item_subscriber';
	protected $defaultSorter = 'email';
	protected $defaultOrder = 'ASC';

	protected function prepareData(){
		if (!empty($this->theme)){
			$themes = explode(',',$this->theme);
			$this->theme = array();
			foreach ($themes as $theme){
				if (!empty($theme)) $this->theme[] = $theme;
			}
		} else {
			$this->theme = array();
		}
	}

	protected function getData(){
		$data = array(
			'email' => $this->email,
			'title' => empty($this->title) ? '' : $this->title,
			'theme' => join(',',$this->theme),
			'active' => empty($this->active) ? 0 : 1,
			);
		return $data;
	}

	// возвращает объект RecordSet содежащий выборку из базы в объектах
	public static function getList($parameters = array(),$limiter = null,$class = 'Item_Subscriber'){
		return parent::getList($parameters,$limiter,$class);
	}

	// возвращает объект RecordSet содежащий выборку из базы
	public static function getListArray($parameters = array(), $limiter = null, $class = 'Item_Subscriber'){
		return parent::getListArray($parameters,$limiter,$class);
	}

	public static function getByKey($key, $value, $class = 'Item_Subscriber'){
		return parent::getByKey($key,$value,$class);
	}

	public static function getListByKey($key,$value, $limiter = null,$class = 'Item_Subscriber'){
		return parent::getListByKey($key,$value, $limiter,$class);
	}

	public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	public function validate() {
		$valid = true;
		/*if (empty($this->theme)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо выбрать тематики подписки', 'error');
		}
		if (empty($this->title)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо заполнить поле «ФИО»', 'error');
		}*/
		if (!preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/u', $this->email)) {
			$valid = false;
			$this->errors[] = new Message('Неверный формат адреса электронной почты. <em>Пример: v.pupkin@gmail.com.</em>', 'error');
		}
		return $valid;
	}

	public static function getByTheme($themes,$not = null,$limit = false){
		$db = Registry::get('db');
		$list = $db->query(sprintf("SELECT id, theme FROM %s WHERE ?",self::getVar('table')), [1])->toArray();
		$ids = array();
		foreach ($list as $item){
			if (!empty($item['theme'])){
				$i_themes = explode(',',$item['theme']);
				$common_themes = array_intersect($themes,$i_themes);
				if (!empty($common_themes) && $not != $item['id']){
					$ids[] = $item['id'];
				}
			} else {
				$ids[] = $item['id'];
			}
		}
		return empty($ids) ? array() : self::getList(array('filters' => array(sprintf('id IN (%s)',join(',',$ids))),'sorters' => array('email ASC')),$limit)->getItems();
	}

	public static function getByEmail($email) {
		return static::getByKey('email',$email);
	}

}
?>
