<?

namespace App\Item\Infocenter;

use App\Item\Infocenter;
use App\Template;
use App\File;

class Banner
{

    const TEMPLATE_PATH = 'module/infocenter/include/banner.tpl';
    private ?Infocenter $object = null;
    public function __construct(Infocenter $object)
    {
        $this->object = $object;
    }


    public function prepareItem()
    {
        if(
            !empty($this->object->banner_file)
            && !is_object($this->object->banner_file)
        ) {
            $this->object->banner_file = new File($this->object->banner_file);
        }
        
        return $this->object;
    }

    public function getHtml()
    {
        $template = new Template();
        $template->assign('content', $this->object);
        $template->assign('class', 'blog__it');
        return $template->fetch(self::TEMPLATE_PATH);
    }
}