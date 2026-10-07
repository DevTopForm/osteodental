<?php
class Item_Notice extends Model {

	protected $table = 'item_notice';
	protected $defaultSorter = 'id';
	protected $defaultOrder = 'ASC';

	protected function prepareData(){
	}

	protected function getData(){
		$data = array(
			'name'	=> $this->name,
			'email'	=> $this->email,
			'item'	=> $this->item
		);
		return $data;
	}	

	public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	public function validate() {
		$valid = true;
		if (empty($this->name)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо заполнить поле «Имя»', 'error');
		}
		if (empty($this->email) || !preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/u', $this->email)) {
			$valid = false;
			$this->errors[] = new Message('Неверный формат адреса электронной почты. <em>Пример: v.pupkin@gmail.com.</em>', 'error');
		}
		return $valid;
	}
}
?>
