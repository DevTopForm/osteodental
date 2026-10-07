<?php
/**
 * StringBuffer - A very weak implementation of StringBuffer java class
 * 
 * Copyright (c) 2005 eSector Solutions <info@esectorsolutions.com>
 * 
 * This script is free software; you can redistribute it and/or modify   
 * it under the terms of the GNU General Public License as published by  
 * the Free Software Foundation; either version 2 of the License, or     
 * (at your option) any later version.                                   
 *                                                                       
 * The GNU General Public License can be found at                      
 * http://www.gnu.org/copyleft/gpl.html.                                 
 *                                                                       
 * This script is distributed in the hope that it will be useful,        
 * but WITHOUT ANY WARRANTY; without even the implied warranty of        
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the          
 * GNU General Public License for more details.        
 * 
 * @author: Anton A. Kovalyov
 */
 
class StringBuffer {
	var $data;
	
	// Default and single constructor
	function StringBuffer($string) {
		$this->data = $string;
	}
	
	// Sets specified length
	function setLength($length) {
		if($length < $this->getLength()) {
			$this->data = substr($this->data, 0, $length);
		} else {
			$this->data = str_pad($this->data, $length);
		}
	}
	
	// Gets $data's length
	function getLength() {
		return strlen($this->data);
	}
	
	// Gets char at specified position
	function charAt($index) {
		return $this->data{$index};
	}
	
	// Gets string
	function getString() {
		return $this->data;
	}
	
	// Sets string
	function setString($string) {
		$this->data = $string;
	}
}
?>