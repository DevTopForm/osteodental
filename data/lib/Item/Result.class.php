<?php
class Item_Result extends Model {

  protected $table = 'result_voting';
	public $id;
	public $node;
	public $ip;
	public $date;
	public $data;

  protected function prepareData(){
  }

  protected function getData(){
    $data = array(
      'item'    => $this->item,
      'variant' => $this->variant,
      'ip'      => $this->ip,
      'date'    => empty($this->date) ? time() : $this->date,
    );
    return $data;
  }

  public static function getVar($name){
		$fields = get_class_vars(__CLASS__);
		return $fields[$name];
	}

  public function validate() {
		$valid = true;
    return $valid;
  }

  public static function isVoted($item){
    $ccode = sprintf('voted-%s',$item->id);
    if (isset($_COOKIE[$ccode])){
			return true;
		}
    if(empty($item->node->id))
      $item->node = new Node($item->node);
    $params = $item->node->getParams(0);
    $maxVotes = empty($params['max_votes']) ? 15 : $params['max_votes'];
		$votesCount = 0;
		foreach ($item->results as $result){
			if ($result->ip == $_SERVER['REMOTE_ADDR']){
				$votesCount++;
			}
		}
		if ($votesCount >= $maxVotes){
			return true;
		}
		return false;
  }

}
?>
