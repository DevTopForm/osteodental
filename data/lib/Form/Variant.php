<?php

namespace App\Form;

use App\Node\Variant\Field as VariantField;
use App\Node\Variant\Item;
use App\Query;

class Variant extends Text {

	protected $class = "variant";

	public function getInsertValue(){
		return empty($this->value) ? 0 : 1;
	}

	public function setValue($value){
		if(empty($this->item->node->id)) return;
		$params = $this->item->node->getParams();
		//получение полей вариантов
		$this->inner_fields = VariantField::getList($this->item->node->type->type);

		//получение значений полей вариантов
		$variants = $this->item->getVariants();
		if($variants) foreach($variants as $variant_key => $variant){
			foreach($this->inner_fields as $f_key => $field){
				//name new variant
				$field->setParams($params);
				$field->setName(sprintf("%s_%s_%s", $this->name, 'new', $this->inner_fields[$f_key]->name));

				//set fields
				$clone_field = new Node_Variant_Field($field);
				$clone_field->setParams($params);
				$name = $clone_field->name;
				$clone_field->setName(sprintf("%s_%s_%s", $this->name, $variant->id, $this->inner_fields[$f_key]->name));
				$clone_field->setValue(empty($variant->$name) ? '' : $variant->$name);
				$variants[$variant_key]->nodes_fields[$clone_field->id] = $clone_field;
			}
		}
	//pre($this->variants);
		$this->variants = $variants;
	}

	public function prepareValue($value){
		return '';
	}

	public function getSpecValue() {
		return array(
			'fields' => $this->inner_fields,
			'variants' => $this->variants
		);
	}

	public function validate(){
		$this->messages = array();
		if($this->variants) foreach($this->variants as $variant){
			$variant->item = $this->item;

			//удаление
			if(!empty(Query::$post['remove_'.$this->name]) && in_array($variant->id, Query::$post['remove_'.$this->name])){
				$variant->node = $this->item->node;
				$variant->delete();
				continue;
			}

			if ($variant->validate()){
				$variant->save();
			}else{
				$this->messages = array_merge($this->messages, $variant->errors);
			}
		}
		//новый
		if(!empty($this->inner_fields[0]->name) && !empty(Query::$post[$this->inner_fields[0]->getName()])){
			$new = new Item($this->item->node->getTable().'_variant');
			$new->nodes_fields = $this->inner_fields;
			$new->item = $this->item;
			if ($new->validate()){
				$new->save();
			}else{
				$this->messages = array_merge($this->messages, $new->errors);
			}
		}
		return $this->messages;
	}
}
?>
