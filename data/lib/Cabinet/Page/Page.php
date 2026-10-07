<?php

namespace App\Cabinet\Page;

use App\Node;
use App\Structure;
use App\Utils;
use Smarty\Exception;

class Page extends Model
{
    protected string $localTpl = 'cabinet/default_page.tpl';
    protected $item = null;
    protected array $errors = [];
    protected bool $withcounter = true;

    /**
     * @throws Exception
     */
    protected function parseContent()
    {
        $data = Structure::get_instance()->get_node_by_url('/service/cabinet/' . $this->relativePath);
        if (!empty($data)) {
            $page = new Node($data['id'], $data);
            $tpl = $this->getTpl();
            $tpl->assign('content', $page->display_ajax());
            return $tpl->fetch($this->localTpl);
        } else {
            Utils::redirect('/cabinet');
        }
    }
}