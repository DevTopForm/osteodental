<?php

namespace App\Form;

use App\Attach;
use App\Query;

class Multifile extends File {
	
	protected $attaches = array();


	public function getInsertValue(){
		$values = array();
		foreach ($this->attaches as $attach){
			$values[] = $attach->id;
		}
		return join(';',$values);
	}

	public function setValue($value){
		if (!empty($value)){
			$this->value = $value;
			$ids = explode(';',$this->value);
			foreach ($ids as $id){
				$this->attaches[$id] = Attach::factory($this->attach_type,$id,$this->params);
			}
		}
	}

	public function getSpecValue(){
		return $this->attaches;
	}

	public function setQueryValue(){		
		if (!empty(Query::$post['clear_'.$this->name])){
			foreach (Query::$post['clear_'.$this->name] as $id => $value)
			if (!empty($this->attaches[$id])){
				$this->attaches[$id]->delete();
				unset($this->attaches[$id]);
			}
		}

		if(!empty(Query::$post[$this->name.'_broswer'])){
			foreach (Query::$post[$this->name.'_broswer'] as $file){
				$attach = Attach::factory($this->attach_type,0, $this->params);
				$attach->uploadFromServer($file);
				$this->value = empty($this->attach->id) ? 0 : $this->attach->id;
				if (!empty($attach->id)){
					$this->attaches[$attach->id] = $attach;
				}
			}
			return;
		}

		if (!empty(Query::$files[$this->name])){
			foreach (Query::$files[$this->name] as $file){
				$attach = Attach::factory($this->attach_type,0,$this->params); 
				$attach->upload($file);
				if (!empty($attach->id)){
					$this->attaches[$attach->id] = $attach;
				}
			}
		}
	}

	public function getHtml($id = null, $name = "") {
		return $this->getHtmlInput();
	}

	protected function getHtmlInput($attrs = array()) {
		$attrs['id'] = empty($this->id) ? $this->name : $this->id;
		$attrs['type'] = $this->type;
		$attrs['name'] = $this->name.'[]';
		$attrs['value'] = $this->value;
		$attrs['class'] = $this->class;
		return sprintf('<input %s />', $this->_make_attributes_html($attrs));
	}


}
?>
