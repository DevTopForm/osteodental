<?php
class Node_Filter extends Model{

	protected $table = 'nodes_filter';
	protected $defaultSorter = 'weight';
	protected $isCachable = true;

	public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}
	
	protected function getData(){
		$data = array(
			'type' => $this->type,
			'filter' => $this->filter,
			'title' => $this->title,
			'field' => $this->field,
			'multiple' => empty($this->multiple) ? 0 : 1,
			'weight' => empty($this->weight) ? 0 : $this->weight,
		);
		return $data;
	}

	public function validate() {
		$valid = true;
		if (empty($this->title)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо указать название фильтра', 'error');
		}
		if (empty($this->type)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо указать тип раздела', 'error');
		}
		if (empty($this->filter)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо выбрать "Тип фильтра"', 'error');
		}
		if (empty($this->field)) {
			$valid = false;
			$this->errors[] = new Message('Необходимо выбрать поле для фильтрации', 'error');
		}
		return $valid;
	}
}
?>
