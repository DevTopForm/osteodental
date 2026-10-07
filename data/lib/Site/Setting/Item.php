<?php
namespace App\Site\Setting;

use App\Setting\Item as SettingItem;

class Item extends SettingItem{
	
	protected $table = 'site_params_values';

	protected static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

	public static function get($type,$params = array()){
		return self::getDbData($type,self::getVar('table'),__CLASS__,$params);
	}
}
?>
