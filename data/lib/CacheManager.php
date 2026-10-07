<?php

namespace App;

use Laminas\Cache\StorageFactory;

class CacheManager
{

    private static $instance;

    private $fileCacher;
    private $memoryCacher;

    private $defaultLifetime = 86400; // время жизни кэша - 1 день

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->initFileCacher();
    }

    private function __clone()
    {
    }

    private function getDefaultFrontEndOptions()
    {
        return array(
            'lifetime' => $this->defaultLifetime,
            'automatic_serialization' => true
        );
    }

    private function getBackEndOptions($backendType)
    {
        if ('File' == $backendType) {
            return array(
                'cache_dir' => Params::$params['cache_path'],
            );
        } else {
            return array();
        }
    }

    private function initFileCacher()
    {
        $this->fileCacher = StorageFactory::factory([
            'adapter' => [
                'name' => 'Filesystem',
                'options' => [
                    'cache_dir' => Params::$params['cache_path'],
                    'ttl' => $this->defaultLifetime
                ],

            ]
        ]);
        /*$this->fileCacher = Zend_Cache::factory(
            'Core',
            'File',
            $this->getDefaultFrontEndOptions(),
            $this->getBackEndOptions('File')
        );*/
    }

    public function checkCache($cacheId)
    {
        return $this->fileCacher->hasItem($cacheId);
    }

    public function getCache($cacheId)
    {
        //return $this->fileCacher->load($cacheId);
        if (!empty($this->fileCacher->getItem($cacheId))) {
            return @unserialize($this->fileCacher->getItem($cacheId));
        }
        return '';
    }

    public function setCache($cacheId, $cachedData, $timeLife = null)
    {
        if (empty($cacheId)) {
            throw new \Exception('Empty cache id provided');
        }
        /*if (!is_null($timeLife)) {
            $this->fileCacher->save($cachedData, $cacheId, array(), $timeLife);
        } else {
            $this->fileCacher->save($cachedData, $cacheId);
        }*/
        $this->fileCacher->setItem($cacheId, serialize($cachedData));
    }

    public function removeCache($cacheId)
    {
        $this->fileCacher->removeItem($cacheId);
    }

    public static function getIds()
    {
        $cm = CacheManager::getInstance();
        return $cm->fileCacher->getItems();
    }

    public static function clear_content($key = '')
    {
        $cm = CacheManager::getInstance();
        $cm->removeCache("content_" . $key);
    }

    public static function clear_cache()
    {
        $cm = CacheManager::getInstance();
        $cm->fileCacher->clearByNamespace($cm->fileCacher->getOptions()->namespace);
    }
}
