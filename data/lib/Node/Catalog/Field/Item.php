<?

namespace App\Node\Catalog\Field;

use App\Node\Field\Item as NodeFieldItem;
use App\Registry;

class Item extends NodeFieldItem
{
    protected $table = 'nodes_catalog_fields';

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    protected function insertAction()
    {
        return false;
    }

    //действия после обновления объекта
    protected function updateAction()
    {
        return false;
    }
}