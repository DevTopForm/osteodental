<?php
namespace App\Site\Controller;


use App\Item\Catalog;
use App\Query;
use App\Site\Controller;
use App\Site\Favorite as SiteFavorite;

class Favorite extends Controller {

	protected $model = SiteFavorite::class;
	protected $template = 'module/favorite/items.tpl';

	public function isDispatchable($pathStr){
		$pathStr = $this->removePathPrefix($pathStr);
		return preg_match(
			'/^favorite\/.*$/',
			$pathStr
		);
	}

	public function run(){
		$model = $this->model;

		if(!empty($this->path[1]) && $this->path[2]){
            $response = [
                'success' => false
            ];

			switch($this->path[1]){
				case 'add':
                    $item = new Catalog($this->path[2]);

                    if (!empty($item->id)) {

                        $model::getInstance()->addItem($item);
                        $response['success'] = true;
                    }

                    $response['total'] = $model::getInstance()->getTotal();
                    break;
                case 'remove':
                    $model::getInstance()->removeItem($this->path[2]);

                    $response = [
                        'success' => true,
                        'total' => $model::getInstance()->getTotal()
                    ];

                    break;
			}

            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            die();
		}
	}
}
