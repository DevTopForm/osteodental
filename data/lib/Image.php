<?php

namespace App;

use App\Image\Resizer;
use App\Image\Setting as ImageSetting;

class Image extends File
{

    protected $allowed_ext = array('jpeg', 'jpg', 'gif', 'png', 'svg', 'webp');

    protected $resizer = null;

    private function get_resizer()
    {
        if (is_null($this->resizer)) {
            $this->resizer = new Resizer();
            $this->resizer->source = $this->getUploadPath($this->node_type) . $this->name;
        }
        return $this->resizer;
    }

    public function afterUploadFile($path, $node_type)
    {
        if (!empty($this->params['max_upload_image'])) {
            $max_size = explode('x', $this->params['max_upload_image']);
            if (count($max_size) != 2) {
                $max_size[0] = 8001;
                $max_size[1] = 8001;
            }
            $size = getimagesize($path);
            if (($size[0] > $max_size[0]) || ($size[1] > $max_size[1])) {
                $this->messages[] = new Message(
                    'Максимальный размер картинки ' . $this->params['max_upload_image'] . ' пикселей', 'error'
                );
                $this->id = 0;
                unlink($path);

                pre($this->messages);
                die();

                return false;
            }
        }

        if (!empty($this->params['max_image_width'])) {
            try {
                ini_set('memory_limit', '256M');
                $resizer = new Resizer();
                $resizer->source = $path;
                $resizer->set_wmark = 0;
                $resizer->folder = $this->getUploadPath($node_type);
                $resizer->d_w = $this->params['max_image_width'];
                $resizer->d_h = 0;
                $resizer->run();
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }

    public function resize($type = 'default')
    {
        $resizer = $this->get_resizer();
        //получить настройки для типа.
        $settings = $this->getSizeByKey($type);
        $this->crop = empty($this->crop) ? array() : (is_array($this->crop) ? $this->crop : @unserialize($this->crop));
        if (!empty($settings->id)) {
            try {
                if (isset($this->params['watermark'])) {
                    $resizer->set_wmark = ($this->params['watermark']) ? $settings->watermark : 0;
                } else {
                    $resizer->set_wmark = 0;
                }
                if (isset($this->params['wmark_text'])) {
                    $resizer->wmark_text = $this->params['wmark_text'];
                }
                if (isset($this->params['wmark_image'])) {
                    $resizer->wmark_image = $this->params['wmark_image'];
                }
                $resizer->folder = $this->getUploadHttpPath($type, $this->node_type);
                $resizer->d_w = $settings->width;
                $resizer->d_h = $settings->height;
                $resizer->run();
                if (!empty($this->crop[$type])) {
                    $crop = $this->crop[$type];
                    if (!empty($settings->width) && !empty($settings->height)) {
                        $koef1 = round($settings->width / $settings->height * 10);
                        $koef2 = round(($crop[2] - $crop[0]) / ($crop[3] - $crop[1]) * 10);
                        if ($koef1 == $koef2) {
                            $resizer->setCropData($crop[0], $crop[1], $crop[2], $crop[3]);
                            $resizer->crop();
                        }
                    }
                }
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    public function getSizes($type = null)
    {
        return ImageSetting::getInstance()->getByType(empty($type) ? $this->node_type : $type);
    }

    public function getSizeByKey($key)
    {
        return ImageSetting::getInstance()->getByKey($key, $this->node_type);
    }

    public function recrop(
        $type,
        $x1 = 0,
        $y1 = 0,
        $x2 = 100,
        $y2 = 100,
        $th_w = 100,
        $th_h = 100,
        $bx = null,
        $by = null
    ) {
        if (!is_array($this->crop)) {
            $this->crop = unserialize($this->crop);
        }
        $resizer = $this->get_resizer();
        $resizer->folder = $this->getUploadHttpPath($type, $this->node_type);
        $resizer->d_w = $th_w;
        $resizer->d_h = $th_h;
        $resizer->setCropData($x1, $y1, $x2, $y2, $bx, $by);
        $this->crop[$type] = $resizer->crop();
//        pre($this->crop[$type]);
        $this->save_crop();
    }

    public function getLink($type = 'default', $url = true)
    {
        $path = $this->getUploadHttpPath($type, $this->node_type) . $this->name;
        if (!is_file($path)) {
            $this->resize($type);
            if (!is_file($path)) {
                return '';
            }
        }
        return ($url) ? $this->getUploadHttp($type, $this->node_type) . $this->name : $path;
    }

    public function prepareDelete()
    {
        $sizes = $this->getSizes();
        foreach ($sizes as $type => $settings) {
            $path = $this->getUploadHttpPath($type, $this->node_type) . $this->name;
            if (is_file($path)) {
                unlink($path);
            }
        }
        $path = $this->getUploadHttpPath('default', $this->node_type) . $this->name;
        if (is_file($path)) {
            unlink($path);
        }
        $path = $this->getUploadPath($this->node_type) . $this->name;
        if (is_file($path)) {
            unlink($path);
        }
    }

    public function getUploadPath($node_type = '')
    {
        if ($node_type) {
            $path = Params::$params['upload_images_path'] . $node_type . "/";
        } else {
            $path = Params::$params['upload_images_path'] . (empty($this->params['node_type']) ? 'default' : $this->params['node_type']);
        }
        if (!is_dir($path)) {
            mkdir($path, 0777);
        }
        return $path . '/';
    }

    public function getUploadHttpPath($type = '', $node_type = "")
    {
        $typePath = sprintf(
            '%s%s/',
            Params::$params['upload_images_http_path'],
            (($node_type) ? $node_type : "default")
        );
        if (!is_dir($typePath)) {
            mkdir($typePath, 0777);
        }
        $HttpPath = $typePath . $type;
        if (!is_dir($HttpPath)) {
            mkdir($HttpPath, 0777);
        }
        return $HttpPath . "/";
    }

    public function getUploadHttp($type = '', $node_type = "")
    {
        return Params::$params['upload_images_http'] . (($node_type) ? $node_type : "default") . "/" . $type . "/";
    }

    public function save_crop()
    {
        $data = array('crop' => serialize($this->crop), 'title' => $this->title, 'alt' => $this->alt);
        $this->crop = $data['crop'];
        
        $db = Registry::get('db');
        if (!empty($this->id)) {
            $update = $db->sql->update();
            $update->table($this->table);
            $update->set($data);
            $update->where('id=' . $this->id);
            $db->query($db->sql->buildSqlString($update), $db::QUERY_MODE_EXECUTE);
            $this->updateAction();
        } else {
            $insert = $db->sql->insert();
            $insert->into($this->table);
            $insert->columns(array_keys($data));
            $insert->values($data);
            $db->query($db->sql->buildSqlString($insert), $db::QUERY_MODE_EXECUTE);
            $this->id = $db->getDriver()->getConnection()->getLastGeneratedValue();
        }
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function copy($url, $node_type)
    {
        $img = file_get_contents($url);
        if (empty($img)) {
            return null;
        }
        $file = array();
        $file['name'] = basename($url);
        $file['extension'] = strtolower(array_pop(explode('.', $file['name'])));
        $filename = $this->getPossibleName($url, $node_type) . $file['extension'];
        $path = $this->getUploadPath($node_type) . $filename;
        $name = basename($file['name'], '.' . $file['extension']);
        file_put_contents($path, $img);
        $size = getimagesize($path);

        $db = Registry::get('db');
        $data = array(
            'src_name' => Utils::translit($name) . '.' . $file['extension'],
            'name' => $filename,
            'node_type' => $node_type,
            'mime' => $size['mime'],
            'extension' => $file['extension'],
            'title' => '',
            'description' => '',
        );

        $insert = $db->sql->insert();
        $insert->into($this->table);
        $insert->columns(array_keys($data));
        $insert->values($data);
        $db->query($db->sql->buildSqlString($insert), $db::QUERY_MODE_EXECUTE);
        $this->id = $db->getDriver()->getConnection()->getLastGeneratedValue();
        $this->loadData();
    }
}

?>