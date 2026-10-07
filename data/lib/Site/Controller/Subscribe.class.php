<?php

class Site_Controller_Subscribe extends Site_Controller_Abstract{

	protected $model = 'Site_Subscribe';

	public function isDispatchable($pathStr){
		$pathStr = $this->removePathPrefix($pathStr);
		return preg_match(
			'/^subscribe\/.*$/',
			$pathStr
		);
	}

	public function run(){
		$model = $this->model;
		$status = 'error';
		switch($this->path[1]){
			case 'subscribe':
        if (preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/u', Query::$get['email'])) {
          $user = Cabinet_User::getByEmail(Query::$get['email']);
          if(!empty($user->id)){
            $user->subscribe = 1;
            $user->recipe_category = empty(Query::$get['theme']) ? array() : explode(',',Query::$get['theme']);
            $user->save();
          } else {
    				$subscriber = Item_Subscriber::getByKeys(array('email' => Query::$get['email']));
    				if (!empty($subscriber->id)){
              $subscriber->theme = empty(Query::$get['theme']) ? array() : explode(',',Query::$get['theme']);
              $subscriber->active = 1;
              $subscriber->save();
    				} else {
              $subscriber = new Item_Subscriber();
              $subscriber->email = strip_tags(Query::$get['email']);
              $subscriber->theme = empty(Query::$get['theme']) ? array() : explode(',',Query::$get['theme']);
              $subscriber->active = 1;
              $subscriber->save();
            }
          }
          $status = 'success';
        }
				break;
			case 'unsubscribe':
        if (preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/u', Query::$get['email'])) {
          $user = Cabinet_User::getByEmail(Query::$get['email']);
          if(!empty($user->id)){
						if(Query::$get['hash']==md5($user->email.'fgdgn')){
	            $user->subscribe = 0;
	            $user->save();
	            $status = 'success';
							Utils::redirect('/service/unsubscribe');
						}
          } else {
            $subscriber = Item_Subscriber::getByKeys(array('email' => Query::$get['email']));
            if (!empty($subscriber->id) && Query::$get['hash']==md5($subscriber->email.'fgdgn')){
              $subscriber->active = 0;
              $subscriber->save();
              $status = 'success';
							Utils::redirect('/service/unsubscribe');
            }
          }
        }
				break;
		}
		if (!empty(Query::$get['ajax'])){
			$result = array('status' => $status);
			echo json_encode($result);
			die;
		} else {
			Utils::redirectPrevious();
		}
	}
}
