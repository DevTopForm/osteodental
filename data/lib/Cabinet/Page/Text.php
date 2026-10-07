<?php

namespace App\Cabinet\Page;

use App\Template;
use Smarty\Exception;

class Text extends Model
{

    const STATE_TEXT = 'text';

    protected string $localTpl = 'cabinet/text.tpl';

    protected function defineState(): void
    {
        $this->state = self::STATE_TEXT;
    }

    protected function parseContent(): string
    {
        $method = sprintf('parseState%s', ucfirst($this->state));
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        return sprintf('Пока не определено отображение для состояния: %s. Метод: %s', $this->state, $method);
    }

    /**
     * @throws Exception
     */
    protected function parseStateText(): string
    {
        $tpl = $this->getTextTpl();
        return $tpl->fetch($this->localTpl);
    }

    protected function getTextTpl(): Template
    {
        $tpl = $this->getLocalTpl();
        $tpl->assign('state', $this->state);
        $tpl->assign('user', $this->user);
        return $tpl;
    }
}