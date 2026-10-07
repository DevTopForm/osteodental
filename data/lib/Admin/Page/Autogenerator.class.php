<?php
	class Admin_Page_Autogenerator extends Admin_Page_LAVED {

    protected $localTpl = 'content/autogenerator.tpl';
		protected $action = 'autogenerator';

		protected $defaultState = 'edit';

    public $messages = array(
      'time'  => 0,
			'error' => array(),
			'info'  => array(
        'updated'  => 0,
        'inserted' => 0,
        'total'    => 0,
			),
 		);

		protected function executeRequestProcessing(){}

		protected function parseStateEdit(){
			$tpl = $this->getItemsTpl();
			$this->db = Registry::get('db');

			if (!empty(Query::$post['submit'])) {
				$item = new Item_Generate();
				if(empty(Query::$post['county'])){
					$item->countries = array();
					Node_Item::$itemsTable = 'content_gencountries';
		      $countries = Node_Item::getList(array('filters' => array('public = 1'), 'sorters' => array('title ASC')))->getItems();
					if(!empty($countries)){
						foreach ($countries as $country) {
							$item->countries[] = $country->id;
						}
					}
				} else {
					$item->countries = Query::$post['county'];
				}
				$item->cities = array();
				if(!empty($item->countries)){
					Node_Item::$itemsTable = 'content_gencities';
					$cities = Node_Item::getList(array('filters' => array('public = 1', 'country IN ('.implode(',', $item->countries).')'), 'sorters' => array('title ASC')))->getItems();
					if(!empty($cities)){
						foreach ($cities as $city) {
							$item->cities[] = $city->id;
						}
					}
				}
				if(empty(Query::$post['type'])){
					$item->type = array();
					Node_Item::$itemsTable = 'content_gentypeshipping';
		      $types = Node_Item::getList(array('filters' => array('public = 1'), 'sorters' => array('title ASC')))->getItems();
					if(!empty($types)){
						foreach ($types as $type) {
							$item->type[] = $type->id;
						}
					}
				} else {
					$item->type = Query::$post['type'];
				}
        $item->status = 0;

        if($item->validate()){
          $item->save();
					$item->genQueue();
        }
			}

			$list = Item_Generate::getList()->getItems();
			if(!empty($list)){
				foreach ($list as $key => $item) {
					if(!empty($item->countries)){
						foreach ($item->countries as $keyC => $country) {
							$item->countries[$keyC] = new Node_Item('content_gencountries', $country);
						}
					}
					if(!empty($item->cities)){
						foreach ($item->cities as $keyCt => $city) {
							$item->cities[$keyCt] = new Node_Item('content_gencities', $city);
						}
					}
					if(!empty($item->type)){
						foreach ($item->type as $keyT => $type) {
							$item->type[$keyT] = new Node_Item('content_gentypeshipping', $type);
						}
					}
					$db = Registry::get('db');
					$queueTotal = $db->query('SELECT SUM(`count`) as `summ` FROM `item_genqueue` WHERE `generate`='.$item->id.' ORDER BY `id` ASC')->execute()->toArray();
					$queueComplete = $db->query('SELECT SUM(`count`) as `summ` FROM `item_genqueue` WHERE `generate`='.$item->id.' AND `status` = 1 ORDER BY `id` ASC')->execute()->toArray();
					$item->success = (empty($queueComplete[0]['summ']) ? 0 : $queueComplete[0]['summ']);
					$item->total = $queueTotal[0]['summ'];
					$list[$key] = $item;
				}
			}
			$tpl->assign('list', $list);
      $tpl->assign('messages',$this->messages);
			$tpl->assign('data', $this->getSpecialListData());
			return $tpl->fetch($this->localTpl);
		}

    protected function getSpecialListData(){
      Node_Item::$itemsTable = 'content_gencountries';
      $country = Node_Item::getList(array('filters' => array('public = 1'), 'sorters' => array('title ASC')));
      Node_Item::$itemsTable = 'content_gentypeshipping';
      $type = Node_Item::getList(array('filters' => array('public = 1'), 'sorters' => array('title ASC')));
  		return array(
        'country' => $country->getItems(),
        'type'    => $type->getItems(),
      );
  	}

  }
?>
