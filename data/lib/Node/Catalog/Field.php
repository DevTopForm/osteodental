<?

namespace App\Node\Catalog;

use App\Node\Field as NodeField;
use App\Registry;

class Field extends NodeField
{
    protected static $fields_table = 'nodes_catalog_fields';

    protected static function getVar($name){
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public static function getFilterList($type){
        $db = Registry::get('db');
        $data = $db->query(sprintf("
			SELECT *
			FROM `%s`
			WHERE `type` = '%s' AND `filter_show` = '%d'
			ORDER BY `weight` ASC
		",static::getVar('fields_table'),$type, 1), $db::QUERY_MODE_EXECUTE)->toArray();
        $fields = array();

        foreach ($data as $item){
            $item = new static($item);
            $fields[] = $item;
        }
        return $fields;
    }
}