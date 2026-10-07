<?php

namespace App;

use App\Params;
use Laminas\Db\ResultSet;
use Laminas\Config\Reader\Ini;

class Application
{

    public static function init()
    {
        Params::init();
        self::initConfig();
        self::initDb();
        self::initWpDb();
        self::initSettings();
        self::initQuery();
    }

    private static function initDirs()
    {
    }

    private static function initConfig()
    {
        $options = array(Params::$params['root_path'] . 'data/config/config.ini');

        $override = Params::$params['root_path'] . 'data/config/config.local.ini';

        if (is_file($override) && is_readable($override)) {
            array_push($options, $override);
        }
        $_options = array();
        foreach ($options as $tmp) {
            $reader = new Ini();
            $config = $reader->fromFile($tmp);
            $_options = self::mergeOptions(
                $_options,
                $config
            );
        }
        Registry::set('config', $_options);
    }

    private static function mergeOptions(array $array1, $array2 = null)
    {
        if (is_array($array2)) {
            foreach ($array2 as $key => $val) {
                if (is_array($array2[$key])) {
                    $array1[$key] = (array_key_exists($key, $array1) && is_array($array1[$key]))
                        ? self::mergeOptions($array1[$key], $array2[$key])
                        : $array2[$key];
                } else {
                    $array1[$key] = $val;
                }
            }
        }
        return $array1;
    }

    public static function getConfig()
    {
        return Registry::get('config');
    }

    private static function initDb(): void
    {
        $config = self::getConfig();
        $db = new Db($config['db']['params'], null, new ResultSet\ResultSet(ResultSet\ResultSet::TYPE_ARRAY));
        Registry::set('db', $db);
    }

    private static function initWpDb(): void
    {
        $config = self::getConfig();

        if(!empty($config['wp_db'])) {
            $db = new Db($config['wp_db']['params'], null, new ResultSet\ResultSet(ResultSet\ResultSet::TYPE_ARRAY));
            Registry::set('wp_db', $db);
        }
    }

    public static function getDb()
    {
        return Registry::get('db');
    }

    public static function getWpDb()
    {
        return Registry::get('wp_db');
    }

    private static function initQuery()
    {
        Query::init();
    }

    private static function initSettings()
    {
        Registry::set('settings', new Setting());
    }
}
