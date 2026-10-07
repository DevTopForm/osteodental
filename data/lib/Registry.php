<?php
namespace App;

class Registry{
	private static $storage = [];

	public static function set($name, $data){
	    self::$storage[$name] = $data;
    }

    public static function get($name){
       return self::$storage[$name];
    }

    public static function isRegistered($name){
	    if(empty(self::$storage[$name]))
	        return false;

	    return true;
    }
}