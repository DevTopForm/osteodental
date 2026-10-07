<?php

namespace App\Admin;

use App\Params;
use App\Template as AppTemplate;

class Template extends AppTemplate
{

    public function __construct()
    {
        parent::__construct();
        $this->template_dir = Params::$params['root_path'] . 'templates/adm/';
        $this->compile_dir = Params::$params['cache_path'] . 'templates/adm/compiled/';
        $this->cache_dir = Params::$params['cache_path'] . 'templates/adm/cached/';

        $this->_create_compile_and_cache_dirs();
        $this->caching = false;

        $this->assign('_LNG_ADM', include(Params::$params['adm_path'] . 'data/lang/ru.php'));
    }
}

?>
