<?php

namespace App\Admin\Controller\Ajax;

use App\Item\Favorite as ItemFavorite;

class Favorite extends Action
{
    protected $tpl = '';

    public function run()
    {
        switch ($this->path[0]) {
            case 'remove':
                $this->remove();
                break;
        }
    }

    protected function remove()
    {
        $success = false;

        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);

        if (!empty($data['id'])) {
            $item = new ItemFavorite($data['id']);
            if ($item->id) {
                $item->delete();
                $success = true;
            }
        }

        echo json_encode(["success" => $success]);
    }
}