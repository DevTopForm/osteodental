<?php
class Item_Order_Sale extends Model {

	protected $table = 'item_sale';
	protected $defaultSorter = 'summ';
	protected $defaultOrder = 'DESC';

	protected function prepareData(){
	}

	protected function getData(){
		$data = array(
			'summ'	=> $this->summ,
			'sale'	=> $this->sale,
			'text'	=> $this->text
		);
		return $data;
	}

	// возвращает карту уже существующих объектов по ключу
	protected function getIdentityMap() {
		$map_key = self::getVar('table').'_map';
		if (!Registry::isRegistered($map_key)) {
			Registry::set($map_key,new Cabinet_Map($map_key));
		}
		return Registry::get($map_key);
	}

	// возвращает объект RecordSet содежащий выборку из базы в объектах
	public static function getList($parameters = array(), $limiter = null, $class = 'Item_Order_Sale'){
		$searcher = self::prepareSearcher($parameters,$limiter);
		$recordSet = $searcher->search();
		$items = array();
		foreach ($recordSet->getItems() as $item){
			$items[] = new $class($item['id'],$item);
		}
		$recordSet->setItems($items);
		return $recordSet;
	}

	// возвращает объект RecordSet содежащий выборку из базы
	public static function getListArray($parameters = array(), $limiter = null, $class = 'Item_Order_Sale'){
		$searcher = self::prepareSearcher($parameters,$limiter);
		$recordSet = $searcher->search();
		return $recordSet;
	}

	// настройки поиска
	public static function prepareSearcher($parameters,$limiter) {
		$settings = Registry::get('settings');
		$searcher = new Searcher();
		$searcher->setTable(self::getVar('table'));
		if (empty($parameters['sorters'])) {
			$parameters['sorters'] = array(sprintf('%s %s',self::getVar('defaultSorter'),self::getVar('defaultOrder')));
		}
		if (is_null($limiter)){
			$searcher->noPager();
		} elseif (is_int($limiter)) {
			$searcher->setPerPage($limiter);
		} else {
			$searcher->setPerPage($settings->getSiteParams('pager'));
		}
		$searcher->applySearchParameters($parameters);
		return $searcher;
	}

	public static function getByKey($key, $value, $class = 'Item_Order_Sale'){
		try {
			$db = Registry::get('db');
			$item = $db->query(sprintf("SELECT * FROM %s WHERE `%s`=?",self::getVar('table'),$key),$value, $db::QUERY_MODE_EXECUTE)->current();
			if (!empty($item['id'])) {
				return new $class($item['id'],$item);
			}
		} catch (exception $e) {

		}
		return false;
	}

	public static function getListByKey($key,$value, $limiter = null,$class = 'Item_Order_Sale'){
		return self::getList(array('filters' => array(sprintf("%s='%s'",$key,$value))), $limiter = null, $class);
	}

	public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	public function validate() {
		$valid = true;
		if (empty($this->text)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо заполнить поле «Комментарий»', 'error');
		}
		if (empty($this->summ)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо заполнить поле «Пороговая сумма»', 'error');
		}
		if (empty($this->sale)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо заполнить поле «Размер скидки»', 'error');
		}
		return $valid;
	}
}
?>
