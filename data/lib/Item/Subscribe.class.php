<?php
class Item_Subscribe extends Model {

	protected $table = 'item_subscribe';
	protected $defaultSorter = 'id';
	protected $defaultOrder = 'ASC';

	protected function prepareData(){
		if (!empty($this->themes)){
			$themes = explode(',',$this->themes);
			$this->themes = array();
			foreach ($themes as $theme){
				if (!empty($theme)) $this->themes[] = $theme;
			}
		} else {
			$this->themes = array();
		}
    if (!empty($this->files)){
			$files = explode(',',$this->files);
			$this->files = array();
			foreach ($files as $file){
				if (!empty($file)) $this->files[] = $file;
			}
		} else {
			$this->files = array();
		}
	}

	protected function getData(){
		$data = array(
			'title' => $this->title,
      'text' => $this->text,
      'date' => $this->date,
			'themes' => join(',',$this->themes),
      'addresses' => $this->addresses,
      'files' => join(',',$this->files),
      'total' => empty($this->total) ? 0 : $this->total,
      'sended' => empty($this->sended) ? 0 : $this->sended,
      'public' => empty($this->public) ? 0 : 1,
      'finished' => empty($this->finished) ? 0 : 1,
			);
		return $data;
	}


	// возвращает объект RecordSet содежащий выборку из базы в объектах
	public static function getList($parameters = array(),$limiter = null,$class = 'Item_Subscribe'){
		return parent::getList($parameters,$limiter,$class);
	}

	// возвращает объект RecordSet содежащий выборку из базы
	public static function getListArray($parameters = array(), $limiter = null, $class = 'Item_Subscribe'){
		return parent::getListArray($parameters,$limiter,$class);
	}

	public static function getByKey($key, $value, $class = 'Item_Subscribe'){
		return parent::getByKey($key,$value,$class);
	}

	public static function getListByKey($key,$value, $limiter = null,$class = 'Item_Subscribe'){
		return parent::getListByKey($key,$value, $limiter,$class);
	}

	public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	public function validate() {
		$valid = true;
		/*if (empty($this->themes)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо выбрать тематики рассылки', 'error');
		}*/
		if (empty($this->title)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо заполнить поле «Заголовок письма»', 'error');
		}
    if (empty($this->date)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо заполнить поле «Дата отправки»', 'error');
		}
		return $valid;
	}

}
?>
