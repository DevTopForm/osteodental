<?php
class Item_Variant extends Item_Catalog{
    protected $table = 'content_catalog_variant';
    // возвращает объект RecordSet содежащий выборку из базы в объектах
    public static function getList($parameters = array(), $limiter = null, $class = 'Item_Variant'){
        $searcher = self::prepareSearcher($parameters,$limiter, $class);
        $recordSet = $searcher->search();
        $items = array();
        foreach ($recordSet->getItems() as $item){
            $items[] = new $class($item['id'],$item);
        }
        $recordSet->setItems($items);
        return $recordSet;
    }

    public static function prepareSearcher($parameters,$limiter, $class) {
        $settings = Registry::get('settings');
        $searcher = new Searcher();
        $searcher->setTable(self::getVar('table'));
        if (empty($parameters['sorters'])) {
            $parameters['sorters'] = array(sprintf('%s %s',self::getVar('defaultSorter'),self::getVar('defaultOrder')));
        }
        if (is_null($limiter)){
            $searcher->noPager();
        } elseif (is_int($limiter)) {
            $searcher->setPerPage($limiter);
        } else {
            $searcher->setPerPage($settings->getSiteParams('pager'));
        }
        $searcher->applySearchParameters($parameters);
        return $searcher;
    }

    public static function getVar($name){
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }
}