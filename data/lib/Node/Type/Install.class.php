<?php
class Node_Type_Install extends Model{

	protected $config = array();
	protected $node_type;
	protected $node_type_alias;
	public $errors = array();

	public function install($node_type_alias){
		$this->node_type_alias = $node_type_alias;
		$this->config = static::getByAlias($node_type_alias);
		if($this->validate()){
			if($this->addType()){
				$this->addFields();
				$this->addParams();
				$this->addTpl();
				$this->addModuleFile();
			}
		}
	}
	public function uninstall($node_type){
		$node_type->delete();
	}

	private function addType(){
		$this->node_type = new Node_Type();
		$this->node_type->type = $this->config['type']['name'];
		$this->node_type->title = $this->config['type']['title'];
		$this->node_type->has_content= empty($this->config['type']['has_content']) ? 0 : 1;
		$this->node_type->has_items	= empty($this->config['type']['has_items']) ? 0 : 1;
		$this->node_type->search	= empty($this->config['type']['search']) ? 0 : 1;
		$this->node_type->in_node	= empty($this->config['type']['in_node']) ? 0 : 1;
		$this->node_type->in_block	= empty($this->config['type']['in_block']) ? 0 : 1;
		$this->node_type->sortable	= empty($this->config['type']['sortable']) ? 0 : 1;
		$this->node_type->has_filters= empty($this->config['type']['has_filters']) ? 0 : 1;
		if($this->node_type->validate()){
			$this->node_type->save();
			return true;
		}else{
			$this->errors = $this->node_type->errors;
		}

	}

	private function addFields(){
		if($this->config['type']['has_content'] && $this->config['fields']){
			foreach($this->config['fields'] as $filed_name => $field_config){
				$node_field = new Node_Fielditem();
				$node_field->type = $this->node_type->type;
				$node_field->name = $filed_name;
				$node_field->title = !empty($field_config['title']) ? $field_config['title'] : '';
				$node_field->field = !empty($field_config['field']) ? $field_config['field'] : '';
				$node_field->show = !empty($field_config['show']) ? $field_config['show'] : '';
				$node_field->example = !empty($field_config['example']) ? $field_config['example'] : '';
				$node_field->editor = !empty($field_config['editor']) ? $field_config['editor'] : '';
				$node_field->format= !empty($field_config['format']) ? $field_config['format'] : '';
				$node_field->required= !empty($field_config['required']) ? $field_config['required'] : '';
				$node_field->weight = !empty($field_config['weight']) ? $field_config['weight'] : '';
				$node_field->table_data = !empty($field_config['table_data']) ? $field_config['table_data'] : '';
				$node_field->table_filter = !empty($field_config['table_filter']) ? $field_config['table_filter'] : '';
				$node_field->table_value = !empty($field_config['table_value']) ? $field_config['table_value'] : '';
				$node_field->sorter = !empty($field_config['sorter']) ? $field_config['sorter'] : '';
				$node_field->sorteri = !empty($field_config['sorteri']) ? $field_config['sorteri'] : '';
				$node_field->default = !empty($field_config['default']) ? $field_config['default'] : '';
				$node_field->disabled = !empty($field_config['disabled']) ? $field_config['disabled'] : '';
				$node_field->prepare = !empty($field_config['prepare']) ? $field_config['prepare'] : '';
				$node_field->unique = !empty($field_config['unique']) ? $field_config['unique'] : '';
				$node_field->advanced = !empty($field_config['advanced']) ? $field_config['advanced'] : '';
				$node_field->search = !empty($field_config['search']) ? $field_config['search'] : '';
				$node_field->inlist = !empty($field_config['inlist']) ? $field_config['inlist'] : '';
				$node_field->property_show = !empty($field_config['property_show']) ? $field_config['property_show'] : 0;
				$node_field->property_list_show = !empty($field_config['property_list_show']) ? $field_config['property_list_show'] : 0;
				$node_field->property_list_show_mobile = !empty($field_config['property_list_show_mobile']) ? $field_config['property_list_show_mobile'] : 0;
				if ($node_field->validate()){
					$node_field->save();
				}else{
					$this->errors = array_merge($this->errors, $node_field->errors);
				}
			}
		}
	}

	private function addParams(){
		if(!empty($this->config['params'])){
			foreach($this->config['params'] as $param_name => $param_config){
				$node_settings_field = new Node_Settings_Fielditem();
				$node_settings_field->type = $this->node_type->type;
				$node_settings_field->name = $param_name;
				$node_settings_field->title = !empty($param_config['title']) ? $param_config['title'] : '';
				$node_settings_field->field = !empty($param_config['field']) ? $param_config['field'] : '';
				$node_settings_field->example = !empty($param_config['example']) ? $param_config['example'] : '';
				$node_settings_field->editor = !empty($param_config['editor']) ? $param_config['editor'] : '';
				$node_settings_field->format = !empty($param_config['format']) ? $param_config['format'] : '';
				$node_settings_field->required = !empty($param_config['required']) ? $param_config['required'] : '';
				$node_settings_field->weight = !empty($param_config['weight']) ? $param_config['weight'] : '';
				$node_settings_field->table_data = !empty($param_config['table_data']) ? $param_config['table_data'] : '';
				$node_settings_field->table_filter = !empty($param_config['table_filter']) ? $param_config['table_filter'] : '';
				$node_settings_field->prepare = !empty($param_config['prepare']) ? $param_config['prepare'] : '';
				$node_settings_field->local = !empty($param_config['local']) ? $param_config['local'] : '';
				$node_settings_field->edit_in_node = !empty($param_config['edit_in_node']) ? $param_config['edit_in_node'] : '';
				if ($node_settings_field->validate()){
					$node_settings_field->save();
				}else{
					$this->errors = array_merge($this->errors, $node_settings_field->errors);
				}
			}
		}
	}

	private function addTpl(){
		if($this->config['templates']){
			$path_from = Params::$params['install_modules'].'/'.$this->node_type->type.'/templates';
			$path_to = Params::$params['root_path'] .'templates/common/module/'.$this->node_type->type;
			if(!file_exists($path_to)) mkdir($path_to, 0777);

			foreach($this->config['templates'] as $template_name => $template_config){
				if(empty($template_config['system'])){
					//INSERT
					$node_tpl = new Node_Type_Template();
					$node_tpl->type = $this->node_type->type;
					$node_tpl->file = !empty($template_config['file']) ? $template_config['file'] : '';
					$node_tpl->title = !empty($template_config['title']) ? $template_config['title'] : '';
					$node_tpl->in_block = !empty($template_config['in_block']) ? $template_config['in_block'] : '';
					if ($node_tpl->validate()){
						$node_tpl->save();
					}else{
						$this->errors = array_merge($this->errors, $node_tpl->errors);
					}
				}
				//copy
				if(file_exists($path_from.'/'.$template_config['file'])){
					copy($path_from.'/'.$template_config['file'], $path_to.'/'.$template_config['file']);
				}
			}
		}
	}

	private function addModuleFile(){
		$from = Params::$params['install_modules'].'/'.$this->node_type->type.'/'.'module.php';
		$to = LIB_DIR.'/Module/'.ucfirst(strtolower($this->node_type->type)).'.class.php';
		if(file_exists($from)) copy($from, $to);

	}

	public static function get_list(){
		$modules = array();
		//add cache ?
		$path = Params::$params['install_modules'];
		$folders = array_slice(scandir($path), 2);
		if($folders){
			foreach($folders as $folder){
				if(file_exists($path.'/'.$folder.'/config.ini')){
					$modules[$folder] = static::scan_config($path.'/'.$folder.'/config.ini');
				}
			}
			return $modules;
		}
		return array();
	}

	public static function getByAlias($alias){
		$path = Params::$params['install_modules'];
		if(file_exists($path.'/'.$alias.'/config.ini')){
			return static::scan_config($path.'/'.$alias.'/config.ini');
		}
		return false;
	}

	public static function scan_config($path){
		$reader = new Laminas\Config\Reader\Ini();
		return $reader->fromFile($path);
	}

	public function validate() {
		$valid = true;
		if (empty($this->config)) {
			$valid = false;
			$this->errors[] = new Message('Файл конфигурации не найден', 'error');
		}
		$exists = Node_Type::getByKey('type', $this->node_type_alias);
		if (!empty($exists->id)) {
			$valid = false;
			$this->errors[] = new Message('Модуль уже установлен', 'error');
		}

		return $valid;
	}

}
?>
