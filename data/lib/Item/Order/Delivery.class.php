<?php
class Item_Order_Delivery extends Model {

	protected $table = 'order_delivery';
	protected $defaultSorter = 'id';
	protected $defaultOrder = 'ASC';

	protected function prepareData(){
	}

	protected function getData(){
		$data = array(
			'title'	=> $this->title,
			'text'	=> $this->text,
			'price'	=> $this->price,
			'active'	=> (!empty($this->active) ? 1 : 0),
		);
		return $data;
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
