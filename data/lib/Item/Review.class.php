<?php
class Item_Review extends Model {

    protected $table = 'content_reviews';
    protected $defaultSorter = 'date';
    protected $defaultOrder = 'DESC';

    /**
     * @return array
     */
    protected function getData():array{
        $data = array(
            'title'	=> empty($this->title) ? '' : $this->title,
            'node' => 4124,
            'product'=> empty($this->product) ? 0 : $this->product,
            'stars'=> empty($this->stars) ? 0 : $this->stars,
            'text'=> empty($this->text) ? '' : $this->text,
            'ip'=> empty($this->ip) ? $_SERVER['REMOTE_ADDR'] : $this->ip,
            'date'=> empty($this->date) ? date('Y-m-d', time()) : $this->date,
            'public'=> empty($this->public) ? 0 : 1
        );
        return $data;
    }

    public static function getVar($name){
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    /**
     * @return bool
     */
    public function validate():bool {
        $valid = true;
        if (empty($this->title)) {
            $valid = false;
            $this->errors[] = 'title';
        }
        if (empty($this->text)) {
            $valid = false;
            $this->errors[] = 'text';
        }
        return $valid;
    }

    /**
     * @param int $id
     */
    public function add(int $id) {
        $this->title = !empty(Query::$post['title']) ? Query::$post['title'] : '';
        $this->text = !empty(Query::$post['text']) ? Query::$post['text'] : '';
        $this->product = $id;
        $this->stars = !empty(Query::$post['stars']) ? Query::$post['stars'] : '';

        $data = array(
            'status' => 'errors'
        );

        if($this->validate()){
            $this->save();
            $data['status'] = 'success';
        }else{
            $data['errors'] = $this->errors;
        }

        echo json_encode($data);
        die();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getReviews(int $id):array{
        $items =  self::getList(array('filters' => array('product = ' . $id, 'public = 1'), 'sorters' => array('date DESC', 'id DESC')), NULL)->getItems();
        if(!empty($items)){
            foreach ($items as $key => $value){
                if(!empty($value->date)){
                    $items[$key]->date = date('d.m.Y', strtotime($value->date));
                }
            }
        }
        return $items;
    }
}
?>
