<?php

namespace App\Item;

use App\Model;
use App\Image;
use App\Query;
use App\Utils;
use App\Message;
use App\Node\Item;
use App\Item\Infocenter\Article;
use App\Item\Infocenter\Banner;
use App\Item\Infocenter\Video;

class Infocenter extends Item
{

    const TYPE_ARTICLE = 56;
    const TYPE_BANNER = 54;
    const TYPE_VIDEO = 55;

    protected $table = 'content_infocenter';
    protected $defaultSorter = 'sorter';
    protected $defaultOrder = 'ASC';

    private ?object $type_class = null;

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function prepareData()
    {
        parent::prepareData();

        $this->type_class = new ($this->getTypeClass())($this);
    }
    
    public function prepareItem()
    {
        if(
            !empty($this->image)
            && !is_object($this->image)
        ) {
            $this->image = new Image($this->image);
        }
        $this->type_class->prepareItem();
        return $this;
    }
    public function getTypeClass()
    {
        return match($this->type){
            self::TYPE_ARTICLE => Article::class,
            self::TYPE_VIDEO => Video::class,
            self::TYPE_BANNER => Banner::class,
        };
    }

    public function getHtml()
    {
        return $this->type_class->getHtml();
    }
}

?>
