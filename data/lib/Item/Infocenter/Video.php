<?

namespace App\Item\Infocenter;

use App\Item\Infocenter;
use App\Template;
use App\File;

class Video
{

    const TEMPLATE_PATH = 'module/infocenter/include/video.tpl';
    private ?Infocenter $object = null;
    public function __construct(Infocenter $object)
    {
        $this->object = $object;
    }


    public function prepareItem()
    {
        if(
            !empty($this->object->video_file)
            && !is_object($this->object->video_file)
        ) {
            $this->object->video_file = new File($this->object->video_file);
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