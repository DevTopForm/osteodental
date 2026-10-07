<?php

namespace App\Cabinet;

use App\Area;
use App\Node;
use App\Params;
use App\Query;
use App\Registry;
use App\Structure;
use App\Template;
use App\Module\Model as ModuleModel;
use Smarty\Exception;

abstract class Page
{
    protected string $tplFile = 'cabinet.tpl';
    protected array $title = [];
    protected array $headers = [];
    protected string $pathPrefix;
    protected string $relativePath;
    protected array $relativeParts = [];
    public array $parts = [];
    public string $state;
    protected Node|null $node = null;
    protected Template $tpl;

    protected $rightpart = true;

    const STATE_ERROR = 'error';

    public function __construct()
    {
        ob_start();
    }

    public function init(): void
    {
        $this->tpl = new Template();
        $data = Structure::get_instance()->get_node_by_url('/service/cabinet');

        if (!empty($data)) {
            $this->node = new Node($data['id'], $data);
        }
    }

    /**
     * @throws Exception
     */
    public function setPathPrefix($str): void
    {
        if (!is_string($str)) {
            throw new Exception('Path prefix must be a string');
        }
        $this->pathPrefix = trim($str, '/');
        if ($this->pathPrefix !== '') {
            $this->pathPrefix = '/' . $this->pathPrefix;
        }
        $this->tpl->assign('path_prefix', $this->pathPrefix);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->preparePaths();
        $this->defineState();
        $this->executeRequestProcessing();
        $this->tpl->assign($this->getParsedBlocks());
        $this->getHTML();
    }

    protected function preparePaths(): void
    {
        if (!$this->checkPrefix()) {
            die('Wrong path and path prefix: "' . join('/', $this->parts) . '"; "' . $this->pathPrefix . '"');
        }
        $path = join('/', $this->parts);
        if ('' === $this->pathPrefix) {
            $this->relativePath = $path;
        } else {
            $this->relativePath = trim(substr($path, strlen($this->pathPrefix) - 1), '/');
        }
        $this->relativeParts = explode('/', $this->relativePath);
    }

    protected function checkPrefix(): bool
    {
        $prefix = trim($this->pathPrefix, '/');
        if ('' === $prefix) {
            return true;
        }
        return str_starts_with(join('/', $this->parts), $prefix);
    }

    protected function defineState()
    {
    }

    protected function executeRequestProcessing()
    {
    }

    protected function getParsedBlocks(): array
    {
        return [
            'content' => $this->parseContent(),
            'rightpart' => $this->rightpart,
        ];
    }

    protected function parseContent()
    {
        return 'Content of: ' . get_class($this);
    }

    /**
     * @throws Exception
     */
    protected function getHTML(): void
    {
        $this->tpl->assign('query', Query::$request);
        $tplFile = 'page/' . (($this->tplFile != '') ? $this->tplFile : 'index.tpl');

        if (!empty($this->node)) {
            $areas = $this->node->getAreas();
            foreach ($areas as $nodeArea) {
                $area = new Area($nodeArea->area);
                if (!empty($nodeArea->object)) {
                    $module = ModuleModel::factory($nodeArea->object->getType());
                    $module->area = $nodeArea;
                    $module->node = $nodeArea->object;
                    $module->mainNode = $this->node;
                    $this->tpl->assign($area->alias, $module->getContent());
                }
            }
            $this->tpl->assign('node', $this->node);
        }

        $settings = Registry::get('settings');
        $params = array_merge(Params::$params['public'], $settings->getSiteParams());
        $this->tpl->assign('params', $params);
        $this->tpl->assign('menu', self::getMenu());
        $this->tpl->assign('hidden', !empty($_COOKIE['hiddenbanner']));
        $this->tpl->assign('cabinet_path', SYS_CABINET_PATH_PREFIX);
        $this->tpl->display($tplFile);
    }

    protected function getLocalTpl(): Template
    {
        $tpl = new Template();
        $tpl->assign('path_prefix', $this->pathPrefix);
        $tpl->assign('cabinet_path', SYS_CABINET_PATH_PREFIX);
        $settings = Registry::get('settings');
        $params = array_merge(Params::$params['public'], $settings->getSiteParams());
        $tpl->assign('params', $params);
        return $tpl;
    }

    protected function getAbsolutePath(): string
    {
        return '/' . join('/', $this->parts);
    }

    protected function getMenu(): array
    {
        return [
            [
                'title' => 'Ваши данные',
                'url' => sprintf('%s/profile', CABINET_PATH_PREFIX)
            ],
            [
                'title' => 'История заказов',
                'url' => sprintf('%s/orders', CABINET_PATH_PREFIX)
            ]
        ];
    }
}
