<?php

namespace App\Admin\Controller\Ajax;

use App\Admin\Template;
use App\Image as AppImage;
use App\Node;
use App\Node\Item;
use App\Node\Field\Item as NodeFieldItem;
use App\Query;

class Image extends Action
{

    protected $tpl = 'ajax/image.tpl';

    public function run()
    {
        switch ($this->path[0]) {
            case 'crop':
                $this->cropImage();
                break;
            case 'save':
                $this->saveImage();
                break;
            case 'upload':
                $this->uploadImage();
                break;
        }
    }

    protected function cropImage()
    {
        $image = new AppImage(@$this->path[1]);
        if (empty($image->id)) {
            throw new \Exception('Image is not defined');
        }
        $sizes = $image->getSizes();
        if (!$sizes) {
            throw new \Exception("Нет доступных видов изображений");
        }

        //картинка не должна быть больше оригинала
        $real_size = @getimagesize($image->getUploadPath($image->node_type) . $image->name);
        if (!$real_size) {
            die();
        }

        $imageCrop = @unserialize($image->crop);

        $data = array();
        foreach ($sizes as $type => $size) {
            $data[$type]['title'] = $size->title . "($size->width". "x" . $size->height . ")";
            $data[$type]['height'] = $imageCrop[$type]['height'] ?: (($size->height > $real_size[1]) ? $real_size[1] : $size->height);
            $data[$type]['width'] = $imageCrop[$type]['width'] ?: (($size->width > $real_size[0]) ? $real_size[0] : $size->width);
            $data[$type]['x1'] = (isset($imageCrop[$type][0])) ? $imageCrop[$type][0] : 0;
            $data[$type]['y1'] = (isset($imageCrop[$type][1])) ? $imageCrop[$type][1] : 0;
            $data[$type]['x2'] = (isset($imageCrop[$type][2])) ? $imageCrop[$type][2] : 0;
            $data[$type]['y2'] = (isset($imageCrop[$type][3])) ? $imageCrop[$type][3] : 0;
            $data[$type]['is_aspect_ratio'] = $imageCrop[$type]['is_aspect_ratio'] === 0 ? 0 : 1;
            $data[$type]['ratio_w'] = (isset($imageCrop[$type]['ratio_w'])) ? $imageCrop[$type]['ratio_w'] : $size->width;
            $data[$type]['ratio_h'] = (isset($imageCrop[$type]['ratio_h'])) ? $imageCrop[$type]['ratio_h'] : $size->height;
        }

        $is_cabinet = false;
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $referer_path = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
            if (str_starts_with($referer_path, '/cabinet')) {
                $is_cabinet = true;
            }
        }

        $tpl = new Template();
        $tpl->assign('is_cabinet', $is_cabinet);

        $tpl->assign('adm_path', SYS_ADMIN_PATH_PREFIX);
        $tpl->assign('state', $this->path[0]);
        $tpl->assign('image', $image);
        $tpl->assign('size', $data);
        $tpl->display($this->tpl);
        die;
    }

    protected function saveImage()
    {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);

        $image = new AppImage(@$this->path[1]);
        if (empty($image->id)) {
            throw new \Exception('Image is not defined');
        }
        $sizes = $image->getSizes();
        if (!$sizes) {
            throw new \Exception("Нет доступных видов изображений");
        }

        //картинка не должна быть больше оригинала
        $real_size = @getimagesize($image->getUploadPath($image->node_type) . $image->name);
        if (!$real_size) {
            throw new \Exception("Не получены данные об оригинальном изображении");
        }

        $image->title = strip_tags($data['title']);
        $image->alt = strip_tags($data['alt']);
        $image->save();

        foreach ($data['crop'] as $key => $cropData) {
            try {
                $x1 = $this->getCrop($key, 'x1');
                $y1 = $this->getCrop($key, 'y1');
                $x2 = $this->getCrop($key, 'x2');
                $y2 = $this->getCrop($key, 'y2');
                $bx = $this->getCrop($key, 'bx');
                $by = $this->getCrop($key, 'by');
                $is_aspect_ratio = $this->getCrop($key, 'is_aspect_ratio');
                $ratio_h = $this->getCrop($key, 'ratio_h');
                $ratio_w = $this->getCrop($key, 'ratio_w');

                if ($x1 == $x2 || $y1 == $y2) {
                    continue;
                }

                $width = ($this->getCrop($key, 'w')) ? $this->getCrop($key, 'w') : $sizes[$key]->width;
                $height = ($this->getCrop($key, 'h')) ? $this->getCrop($key, 'h') : $sizes[$key]->height;
                if (empty($height)) {
                    $height = $width * abs($y2 - $y1) / abs($x2 - $x1);
                } elseif (empty($width)) {
                    $width = $height * abs($x2 - $x1) / abs($y2 - $y1);
                }
                if (($width == 0) && ($height == 0)) {
                    $width = abs($x2 - $x1);
                    $height = abs($y2 - $y1);
                }
                $image->resize($key);
                $image->title = strip_tags($data['title']);
                $image->alt = strip_tags($data['alt']);
                $image->recrop($key, $x1, $y1, $x2, $y2, $width, $height, null, null, $is_aspect_ratio, $ratio_w, $ratio_h);
            } catch (\Exception $e) {
                die('Error: ' . $e->getMessage());
            }
        }
        die("Done");
    }

    private function getCrop($type, $field)
    {
        $postData = file_get_contents('php://input');
        $data = json_decode($postData, true);

        if (isset($data['crop'][$type][$field])) {
            return (int)$data['crop'][$type][$field];
        }
        throw new \Exception('Wrong data ' . $type . '-' . $field);
    }

    protected function uploadImage()
    {
        if (isset(Query::$post['field']) && !empty(Query::$files['Filedata']['tmp_name'])) {
            $node = new Node(Query::$post['node']);
            if (empty($node->id)) {
                die("Error. Node not found");
            }
            $item = new Item($node->getTable(), Query::$post['item']);
            if (empty($item->id)) {
                die("Error. Item not found");
            }
            $field = new NodeFieldItem(Query::$post['field']);
            if (empty($field->id)) {
                die("Error. Field not found");
            }
            $key = $field->name;
            $values = empty($item->$key) ? array() : explode(';', $item->$key);
            $params = $node->getParams();
            $params['file_title'] = empty($item->title) ? (empty($item->name) ? '' : ($item->name)) : ($item->title);
            $image = new Image();
            $image->setParams($params);
            $image->upload(Query::$files['Filedata']);
            if (empty($image->id)) {
                die("Error. Image upload error");
            }
            $values[] = $image->id;
            $item->simpleUpdate($key, join(';', $values));
            echo json_encode(array(
                'id' => $image->id,
                'src' => $image->getLink('thumb'),
                'rel' => sprintf('%s', $image->id)
            ));
            die;
        }
        echo "Error";
        die;
    }
}