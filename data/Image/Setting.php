<?php

namespace App\Image;

use App\CacheManager;
use App\Params;

class Setting
{

    private static $instance = null;

    private $settings = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->loadSettings();
    }

    private function loadSettings()
    {
        $cm = CacheManager::getInstance();
        $settings = $cm->getCache('image_size');
        if (empty($settings)) {
            $settings = Size::getList()->getItems();
            $this->settings = array();
            foreach ($settings as $item) {
                $type = empty($item->type) ? 'default' : $item->type;
                $this->settings[$type][$item->name] = $item;
            }
            $cm->setCache('image_size', serialize($this->settings));
        } else {
            $this->settings = @unserialize($settings);
        }
    }

    public function getByType($type = null)
    {
        if (!empty($type)) {
            return isset($this->settings[$type]) ? $this->settings[$type] : $this->settings['default'];
        } else {
            return $this->settings['default'];
        }
    }

    public function getByKey($key, $type = null)
    {
        $settings = $this->getByType($type);
        return isset($settings[$key]) ? $settings[$key] : (isset($this->settings['default'][$key]) ? $this->settings['default'][$key] : (isset($settings['default']) ? $settings['default'] : $this->settings['default']['default']));
    }

    public function refresh($type = null, $key = null)
    {
        $cm = CacheManager::getInstance();
        $cm->removeCache('image_size');
        if (!empty($type)) {
            $this->refreshDir($type, $key);
        }
    }

    private function refreshDir($type, $key)
    {
        $HttpPath = Params::$params['upload_images_http_path'] . $type . '/' . (empty($key) ? '' : $key);
        $this->removeDir($HttpPath);
    }

    private function removeDir($dir)
    {
        if (is_dir($dir)) {
            if ($list = glob($dir . "/*")) {
                foreach ($list as $file) {
                    if (is_dir($file)) {
                        $this->removeDir($file . '/');
                    } else {
                        unlink($file);
                    }
                }
            }
            rmdir($dir);
        }
    }
}

?>
