<?

namespace App\Item\Infocenter;

use App\Item\Infocenter;
use App\Template;

class Article
{
    
    const TEMPLATE_PATH = 'module/infocenter/include/article.tpl';
    private ?Infocenter $object = null;
    public function __construct(Infocenter $object)
    {
        $this->object = $object;
    }
    
    
    public function prepareItem()
    {

        $this->object->date = date('d.m.Y', strtotime($this->object->date));
        return $this->object;
    }
    
    public function getHtml()
    {
        $template = new Template();
        $template->assign('content', $this->object);
        $template->assign('class', 'blog__it  anim-block anim-popup');
        return $template->fetch(self::TEMPLATE_PATH);
    }
}