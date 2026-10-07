<?php
class Site extends Model{
	
	protected $table = 'site';
	protected $isCachable = true;

	public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	protected function prepareData(){
		if (!empty($this->main)){
			$this->main = new Node($this->main);
		}
	}

	protected function getData(){
		$data = array(
			'title' => $this->title,
			'url ' => $this->url ,
			'main' => empty($this->main) ? 0 : $this->main->id,
			'text' => empty($this->text) ? '' : $this->text,
			'email' => empty($this->email) ? '' : $this->email,
			'path' => empty($this->path) ? '' : $this->path,
		);
		return $data;
	}

	public function validate() {
		$valid = true;
		if (empty($this->title)) {
			$valid = false;
			$this->messages[] = new Message('Название сайта не может быть пустым', 'error');
		}
		if (empty($this->url)) {
			$valid = false;
			$this->messages[] = new Message('Адрес сайта не может быть пустым', 'error');
		}
		return $valid;
	}
	
	public function hasContent(){
		return !empty($this->type->has_content);
	}
	
	public function getParams($area = 0){
		$settings = Registry::get('settings');
		$this->params = $settings->getNodeParams($this,$area);
		$this->params['node_type'] = $this->getType();
		$this->params['node_id'] = $this->id;
		return $this->params;
	}
}
?>