<?php
class Simplefile extends File{
	
	public function afterUploadFile($path){				
		return true;
	}	
	
	public function getUploadPath($type = ''){		
		return Params::$params['upload_path']."/";
	}	
	
	public function getLink($type = 'default', $url = true){
		if($url) return Params::$params['upload_http']."/".$this->name;
		return Params::$params['upload_path'].$this->name;
	}
	
}
?>
