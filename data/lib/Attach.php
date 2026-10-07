<?php
namespace App;

abstract class Attach extends Model{

	public static function factory($type,$id = 0){
		$class = "App\\" . $type;
		if (class_exists($class)){
			return new $class($id);
		}
		return null;
	}
	
}
?>
