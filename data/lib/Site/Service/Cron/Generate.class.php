<?php
class Site_Service_Cron_Generate extends Site_Service_Cron {

	public function run(){
		$generate = Item_Genqueue::getList(array('filters' => array('status = 0')), 1)->getItems();
		if(!empty($generate)){
			$generate = $generate[0];
			$itGen = new Item_Generate();
			if(!empty($generate->data)){
				foreach ($generate->data as $item) {
					$itGen->savePage($item);
				}
				$generate->status = 1;
				$generate->save();
			}
		}
	}

}
?>
