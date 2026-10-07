<?php
class Item_Content extends Model {

	protected $table = 'content_list';
	protected $defaultSorter = 'date';
	protected $defaultOrder = 'DESC';

	// конструктор объекта
	public function __construct($id = 0, $data = array(), $table = '') {
		if (!empty($table)){
			$this->table = 'content_'.$table;
		}
		parent::__construct($id,$data);
	}

	protected function prepareData(){
		$this->node = new Node($this->node);
		$this->url = $this->node->getUrl().(empty($this->alias) ? sprintf('?id='.$this->id) : ('/'.$this->alias));
		if (!empty($this->image)){
			$this->image = new Image($this->image);
		}
	}

	protected function getData(){
		$data = array();
		return $data;
	}	

	public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	public function validate() {
		$valid = true;
		return $valid;
	}
}
?>
