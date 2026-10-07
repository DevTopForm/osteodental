<?php

namespace App;

use Smarty\Smarty;

class Template extends Smarty
{
    public function __construct()
    {
        parent::__construct();
        $this->template_dir = Params::$params['root_path'] . 'templates/common/';
        $this->config_dir = Params::$params['root_path'] . 'data/lib/smarty/config/';
        $this->compile_dir = Params::$params['cache_path'] . 'templates/common/compiled/';
        $this->cache_dir = Params::$params['cache_path'] . 'templates/common/cached/';
        $this->_create_compile_and_cache_dirs();

        $pluginsPath = Params::$params['root_path'] . 'data/lib/Utils/smarty/plugins/';

        // Ensure the lazyimg plugin function is available before registering
        $lazyPluginFile = $pluginsPath . 'outputfilter.lazyimg.php';
        if (!function_exists('smarty_outputfilter_lazyimg') && is_file($lazyPluginFile)) {
            require_once $lazyPluginFile;
        }

        $this->registerFilter('output', 'smarty_outputfilter_lazyimg');

        if (isset(Params::$params['cache_time']) && ((int)Params::$params['cache_time'] > 0)) {
            $this->caching = true;
            $this->cache_lifetime = Params::$params['cache_time'];
        } else {
            $this->caching = false;
        }

        $this->registerPlugin("modifier", "pre", "pre");
        $this->registerPlugin("modifier", "var_dump", "var_dump");
        $this->registerPlugin("modifier", "date", "date");
        $this->registerPlugin("modifier", "nl2br", "nl2br");
        $this->registerPlugin("modifier", "max", "max");
        $this->registerPlugin("modifier", "strip_tags", "strip_tags");
        $this->registerPlugin("modifier", "array_shift", "array_shift");
        $this->registerPlugin("modifier", "array_keys", "array_keys");
        $this->registerPlugin("modifier", "unserialize", "unserialize");
        $this->registerPlugin("modifier", "reset", "reset");
        $this->registerPlugin("function", "offers_slider", "getOffersTemplate");
        $this->registerPlugin("function", "results", "getResultsTemplate");
        $this->registerPlugin("function", "services", "getServicesTemplate");
        $this->registerPlugin("function", "prices", "getPricesTemplate");
    }

    public function fetch($resource_name = null, $cache_id = null, $compile_id = null, $display = false)
    {
        $this->_create_compile_and_cache_dirs();
        return parent::fetch($resource_name, $cache_id, $compile_id, $display);
    }

    protected function _create_compile_and_cache_dirs()
    {
        if (!empty($this->compile_dir) && !is_dir($this->compile_dir)) {
            $oldumask = umask(0);
            mkdir($this->compile_dir, 0777, true);
            umask($oldumask);
        }

        if (!empty($this->cache_dir) && !is_dir($this->cache_dir)) {
            $oldumask = umask(0);
            mkdir($this->cache_dir, 0777, true);
            umask($oldumask);
        }
    }
}

?>
