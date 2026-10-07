<?php

namespace App\Admin;

use App\Image;
use App\Params;
use App\Query;
use App\Registry;

abstract class Page
{

    protected $tplFile = 'page.tpl';
    protected $title = array();
    protected $titleJoiner = ' - ';
    protected $headers = array();
    protected $pathPrefix;
    protected $relativePath;
    protected $relativeParts = array();
    public $parts = array();

    const STATE_ERROR = 'error';

    public function init()
    {
        $this->tpl = new Template();
        $this->admPath = SYS_ADMIN_PATH_PREFIX;
    }

    public function setPathPrefix($str)
    {
        if (!is_string($str)) {
            throw new \Exception('Path prefix must be a string');
        }
        $this->pathPrefix = trim($str, '/');
        if ($this->pathPrefix !== '') {
            $this->pathPrefix = '/' . $this->pathPrefix;
        }
        $this->tpl->assign('path_prefix', $this->pathPrefix);
    }

    public function run()
    {
        $this->preparePaths();
        $this->defineState();
        $this->executeRequestProcessing();
        $this->tpl->assign($this->getParsedBlocks());
        return $this->getHTML();
    }

    protected function preparePaths()
    {
        if (!$this->checkPrefix()) {
            die('Wrong path and path prefix: "' . $path . '"; "' . $this->pathPrefix . '"');
        }
        $path = join('/', $this->parts);
        if ('' === $this->pathPrefix) {
            $this->relativePath = $path;
        } else {
            $this->relativePath = trim(substr($path, strlen($this->pathPrefix) - 1), '/');
        }
        $this->relativeParts = explode('/', $this->relativePath);
    }

    protected function checkPrefix()
    {
        $prefix = trim($this->pathPrefix, '/');
        if ('' === $prefix) {
            return true;
        }
        return 0 === strpos(join('/', $this->parts), $prefix);
    }

    protected function defineState()
    {
    }

    protected function executeRequestProcessing()
    {
    }

    protected function getParsedBlocks()
    {
        return array(
            'content' => $this->parseContent(),
        );
    }

    protected function parseContent()
    {
        return 'Content of: ' . get_class($this);
    }

    protected function getHTML($section = 'page')
    {
        $this->tpl->assign('query', Query::$request);
        $this->tpl->assign('adm_path', SYS_ADMIN_PATH_PREFIX);
        $tplFile = 'page/' . (($this->tplFile != '') ? $this->tplFile : 'index.tpl');
        $settings = Registry::get('settings');
        $params = array_merge(Params::$params['public'], $settings->getSiteParams());
        if (!empty($params['logo'])) {
            $logo = new Image($params['logo']);
            $this->tpl->assign('logo', $logo);
        }
        $this->tpl->assign('params', $params);
        $this->tpl->display($tplFile);
    }

    protected function getLocalTpl()
    {
        $tpl = new Template();
        $tpl->assign('path_prefix', $this->pathPrefix);
        $tpl->assign('adm_path', SYS_ADMIN_PATH_PREFIX);
        $settings = Registry::get('settings');
        $params = array_merge(Params::$params['public'], $settings->getSiteParams());
        $tpl->assign('params', $params);
        return $tpl;
    }

    protected function getAbsolutePath()
    {
        return '/' . join('/', $this->parts);
    }

}
