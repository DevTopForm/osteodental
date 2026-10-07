<?php

namespace App\Cabinet\Page;

use App\Cabinet\LoginManager;
use App\Cabinet\Page;
use App\Registry;
use App\Structure;
use App\Template;
use Smarty\Exception;

abstract class Model extends Page
{

    protected $user;
    protected $menuPage;
    protected $rightpart = true;
    public string $state;
    protected bool $withcounter = false;

    protected array $menu = [
        'profile' => ['title' => 'Мои данные', 'link' => '/cabinet/profile'],
        'orders' => ['title' => 'Мои мероприятия', 'link' => '/cabinet/orders'],
        'experience' => ['title' => 'Мой опыт', 'link' => '/cabinet/experience'],
        'subscribe' => ['title' => 'Подписки', 'link' => '/cabinet/subscribe'],
    ];

    protected string $menuActive = '';

    public function init(): void
    {
        parent::init();
        $this->user = $this->getUser();
    }

    public function setMenuPage($page): void
    {
        $this->menuPage = $page;
    }

    /**
     * @throws Exception
     */
    protected function getParsedBlocks(): array
    {
        $this->parseUserInfo();

        return [
            'content' => $this->parseContent(),
            'cabinetmenu' => $this->parseCabinetMenu(),
        ];
    }

    /**
     * @throws Exception
     */
    protected function parseCabinetMenu(): string
    {
        $tpl = $this->getTpl();
        if (!empty($this->node)) {
            $inner = Structure::get_instance()->get_tree($this->node->id);
            foreach ($inner as $item) {
                $url = str_replace($this->node->getUrl(), '', $item['url']);
                $page = ['title' => $item['title'], 'link' => '/cabinet/page' . $url];
                if ($this->relativePath == trim($url, '/')) {
                    $page['active'] = 1;
                }
                if (!empty($item['public']) && empty($item['nomenu'])) {
                    $this->menu[$item['id']] = $page;
                }
            }
        }
        foreach ($this->menu as $key => $item) {
            if ($key == $this->menuActive) {
                $this->menu[$key]['active'] = 1;
            }
        }
        $tpl->assign('menu', $this->menu);
        return $tpl->fetch('cabinet/blocks/menu.tpl');
    }

    protected function parseUserInfo(): void
    {
        $this->tpl->assign('user', $this->user);
    }

    protected function parseContent()
    {
        return 'Content of: ' . get_class($this);
    }

    protected function getUser()
    {
        try {
            return LoginManager::getLoggedUser();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    protected function getTpl(): Template
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('user', $this->user);
        $tpl->assign('page', $this->menuPage);
        return $tpl;
    }

    protected function getCounterData(): array
    {
        if (!empty($this->withcounter) && !empty($this->user)) {
            $db = Registry::get('db');
            if ($this->user->role == 'applicant') {
                $resume = $db->query(
                    sprintf('SELECT count(*) as `total` FROM `cabinet_resume` WHERE user=%d', $this->user->id),
                    $db::QUERY_MODE_EXECUTE
                )->current();
                $subscribe = $db->query(
                    sprintf('SELECT count(*) as `total` FROM `cabinet_subscribe` WHERE user=%d', $this->user->id),
                    $db::QUERY_MODE_EXECUTE
                )->current();
                $favour = $db->query(
                    sprintf(
                        'SELECT count(*) as `total` FROM `cabinet_vacancy_favour` `cvf` INNER JOIN `content_vacancy` `cv` ON `cv`.id = `cvf`.vacancy WHERE `cvf`.user=%d',
                        $this->user->id
                    ),
                    $db::QUERY_MODE_EXECUTE
                )->current();
                return [
                    'resume' => $resume['total'],
                    'favour' => $favour['total'],
                    'subscribe' => $subscribe['total'],
                ];
            } elseif ($this->user->role == 'employer') {
                $vacancy = $db->query(
                    sprintf(
                        'SELECT count(*) as `total` FROM `content_vacancy` WHERE company=%d AND archive=0',
                        $this->user->company->id
                    ),
                    $db::QUERY_MODE_EXECUTE
                )->current();
                $archive = $db->query(
                    sprintf(
                        'SELECT count(*) as `total` FROM `content_vacancy` WHERE company=%d AND archive=1',
                        $this->user->company->id
                    ),
                    $db::QUERY_MODE_EXECUTE
                )->current();
                $favour = $db->query(
                    sprintf(
                        'SELECT count(*) as `total` FROM `cabinet_resume_favour` `crf` INNER JOIN `cabinet_resume` `cr` ON `cr`.id = `crf`.resume WHERE `crf`.user=%d',
                        $this->user->id
                    ),
                    $db::QUERY_MODE_EXECUTE
                )->current();
                return [
                    'vacancy' => $vacancy['total'],
                    'archive' => $archive['total'],
                    'favour' => $favour['total'],
                ];
            }
        }
        return [];
    }
}
