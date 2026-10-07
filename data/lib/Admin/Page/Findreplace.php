<?php

namespace App\Admin\Page;

use App\Query;
use App\Registry;
use Laminas\Db\ResultSet;
use App\Node as AppNode;

class Findreplace extends LAVED
{

    //Добавить действие через админку - /adm/action
    protected $localTpl = 'content/findreplace.tpl';
    protected $action = 'findreplace';
    protected $fields_modules_name = array();
    protected $list_modules = array();
    protected $fileds_in_params = array();
    protected $inners_text_count = '';
    protected $result_search_modules = array();
    protected $result_search_params = array();
    protected $result_search_inners = array();

    protected function setItemFields()
    {
        $this->post = Query::$post;
    }

    protected function executeRequestProcessing()
    {
        parent::executeRequestProcessing();
        if ($this->state == self::STATE_LIST) {
            $this->updateList();
        }
    }

    protected function getListSorters()
    {
        //return array('sorter' => 'ID DESC');
    }

    protected function getItem()
    {
        //return new Item_Order($this->extractItemId());
    }

    protected function getItemsList()
    {
        //return Item_Order::getList($this->getParameters(),20);
    }

    protected function parseStateEdit()
    {
        // $tpl = $this->getItemsTpl();
        // $statuses = Item_Order_Status::getList();
        // $tpl->assign('statuses',$statuses->getItems());
        // $this->item = $this->getItem();
        // $tpl->assign('item',$this->prepareEditItemHtml($this->item));
        // $tpl->assign('data',$this->getSpecialEditData());
        // $tpl->assign('errors',$this->item->errors);
        // return $tpl->fetch($this->localTpl);
    }

    protected function parseStateList()
    {
        $tpl = $this->getItemsTpl();

        $tpl->assign('list_modules', $this->list_modules);
        $tpl->assign('fileds_in_params', $this->fileds_in_params);
        $tpl->assign('inners_text_count', $this->inners_text_count);
        $tpl->assign('list_modules', $this->list_modules);

        $tpl->assign('result_search_modules', $this->result_search_modules);
        $tpl->assign('result_search_params', $this->result_search_params);
        $tpl->assign('result_search_inners', $this->result_search_inners);

        $tpl->assign('post', $this->post);

        return $tpl->fetch($this->localTpl);
    }

    protected function updateList()
    {
        // в зависимости от версии CMS поправить параметры

        //подключаемся к БД
        $db = Registry::get('db');

        //смотрим все установленные модули
        $all_type_modules = $db->query("SELECT * FROM `nodes_types` WHERE `has_content`<>0 OR `has_items`<>0", []
        )->toArray();

        //ищем все модули, у которых есть текстовое поле с редактором
        if (!empty($all_type_modules)) {
            foreach ($all_type_modules as $keyATM => $valueATM) {
                //$fields_type = $db->fetchAll("SELECT * FROM `nodes_fields` WHERE `type`='".$valueATM['type']."' AND `field`='textarea' AND `editor`=1");
                //поиск по ВСЕМ полям
                $fields_type = $db->query("SELECT * FROM `nodes_fields` WHERE `type`='" . $valueATM['type'] . "'", []
                )->toArray();
                if (!empty($fields_type)) {
                    //список полей каждого модуля
                    foreach ($fields_type as $keyFT => $valueFT) {
                        $this->fields_modules_name[$valueFT['type']][] = $valueFT['name'];
                    }

                    $fields_type_count_elem = $db->query("SELECT COUNT(*) FROM `content_" . $valueATM['type'] . "`", []
                    )->toArray();
                    //если есть итемы
                    if ($fields_type_count_elem[0]['COUNT(*)'] > 0) {
                        $all_type_modules[$keyATM]['count_elem'] = $fields_type_count_elem[0]['COUNT(*)'];
                        $list_modules[] = $all_type_modules[$keyATM];
                    }
                }
            }
        }
        //Получили список
        $this->list_modules = $list_modules;

        //смотрим есть ли текстовые поля в параметрах модулей
        $fileds_in_params = $db->query(
            "SELECT * FROM `nodes_params_fields` WHERE `field`='textarea' AND `editor`=1 ORDER BY `type`",
            []
        )->toArray();
        //поиск по ВСЕМ полям
        //$fileds_in_params = $db->fetchAll("SELECT * FROM `nodes_params_fields` ORDER BY `type`");
        if (!empty($fileds_in_params)) {
            $this->fileds_in_params = $fileds_in_params;
        }

        //смотрим заполнены ли вводные тексты
        $inners_text_count = $db->query("SELECT COUNT(*) FROM `nodes` WHERE `before_text`<>'' OR `after_text`<>''", []
        )->toArray();
        $this->inners_text_count = $inners_text_count[0]['COUNT(*)'];

        $this->setItemFields();
        // Поиск по БД
        if (isset(Query::$post['type_modules']) && !empty(Query::$post['type_modules'])) {
            $search_modules = Query::$post['type_modules'];
        }
        if (isset(Query::$post['fileds_params']) && !empty(Query::$post['fileds_params'])) {
            $search_fileds_params = Query::$post['fileds_params'];
        }
        if (isset(Query::$post['inner_search'])) {
            $search_inners = Query::$post['inner_search'];
        }
        if (isset(Query::$post['search_text'])) {
            $search_text = htmlspecialchars(trim(Query::$post['search_text']), ENT_QUOTES);
        }
        if (isset(Query::$post['replace_text'])) {
            $replace_text = htmlspecialchars(trim(Query::$post['replace_text']), ENT_QUOTES);
        }
        //делаем поиск
        if (!empty($search_text)) {
            //поиск по выбранным модулям
            if (!empty($search_modules)) {
                $this->result_search_modules = $this->search_by_modules($search_text, $search_modules);
            }
            //поиск по полям в параметрах
            if (!empty($search_fileds_params)) {
                $this->result_search_params = $this->search_by_params($search_text, $search_fileds_params);
            }
            //поиск в вводном тексте
            if (!empty($search_inners)) {
                $this->result_search_inners = $this->search_by_inners($search_text);
            }
        }
        //делаем замену
        if (!empty($search_text) && !empty($replace_text)) {
            if (isset(Query::$post['replace_text_ok'])) {
                $this->replace_All(
                    $search_text,
                    $replace_text,
                    $this->result_search_modules,
                    $this->result_search_params,
                    $this->result_search_inners
                );
            }
        }
    }

    protected function search_by_modules($search_text, $list_modules)
    {
        //подключаемся к БД
        $db = Registry::get('db');
        $result_search = array();
        foreach ($list_modules as $keyLM => $valueLM) {
            foreach ($this->fields_modules_name[$valueLM] as $keyTF => $valueTF) {
                $tmp_search = $db->query(
                    "SELECT * FROM `content_" . $valueLM . "` WHERE `" . $valueTF . "` LIKE '%" . $search_text . "%'"
                )->execute()->toArray();
                if (!empty($tmp_search)) {
                    foreach ($tmp_search as $keyTS => $valueTS) {
                        if (empty($tmp_search[$keyTS]['title'])) {
                            $tmp_search[$keyTS]['title'] = $this->getNodeTitle($valueTS['node']);
                        }
                        //$tmp_search[$keyTS]['highlight'] = $this->highlight($valueTS[$valueTF],$search_text);
                        if (empty($valueTS['alias'])) {
                            $alias = '';
                        } else {
                            $alias = $valueTS['alias'];
                        }
                        $tmp_search[$keyTS]['link'] = $this->getLinkItem($valueTS['id'], $valueTS['node'], $alias);
                    }
                    $result_search[$valueLM][$valueTF][] = $tmp_search;
                } else {
                    $result_search[$valueLM][$valueTF][] = array();
                }
            }
        }
        //pre($result_search);
        return $result_search;
    }

    protected function search_by_params($search_text, $list_fields_params)
    {
        //подключаемся к БД
        $db = Registry::get('db');
        $result_search = array();
        foreach ($list_fields_params as $keyLFP => $valueLFP) {
            $tmp_search = $db->query(
                "SELECT * FROM `nodes_params_values` WHERE `value` LIKE '%" . $search_text . "%' AND `name`='" . $valueLFP . "'",
                []
            )->toArray();
            if (!empty($tmp_search)) {
                $result_search[$valueLFP][] = $tmp_search;
            } else {
                $result_search[$valueLFP][] = array();
            }
        }
        return $result_search;
    }

    protected function search_by_inners($search_text)
    {
        //подключаемся к БД
        $db = Registry::get('db');
        $result_search = array();
        //inner
        $tmp_search_inner = $db->query(
            "SELECT `id`,`type`,`before_text` FROM `nodes` WHERE `before_text` LIKE '%" . $search_text . "%'",
            []
        )->toArray();
        if (!empty($tmp_search_inner)) {
            $result_search['before_text'][] = $tmp_search_inner;
        } else {
            $result_search['before_text'][] = array();
        }
        //outer
        $tmp_search_outer = $db->query(
            "SELECT `id`,`type`,`after_text` FROM `nodes` WHERE `after_text` LIKE '%" . $search_text . "%'",
            []
        )->toArray();
        if (!empty($tmp_search_outer)) {
            $result_search['after_text'][] = $tmp_search_outer;
        } else {
            $result_search['after_text'][] = array();
        }
        //meta description
        $tmp_search_meta_description = $db->query(
            "SELECT `id`,`type`,`meta_description` FROM `nodes` WHERE `meta_description` LIKE '%" . $search_text . "%'",
            []
        )->toArray();
        if (!empty($tmp_search_meta_description)) {
            $result_search['meta_description'][] = $tmp_search_meta_description;
        } else {
            $result_search['meta_description'][] = array();
        }
        //meta keywords
        $tmp_search_meta_keywords = $db->query(
            "SELECT `id`,`type`,`meta_keywords` FROM `nodes` WHERE `meta_keywords` LIKE '%" . $search_text . "%'",
            []
        )->toArray();
        if (!empty($tmp_search_meta_keywords)) {
            $result_search['meta_keywords'][] = $tmp_search_meta_keywords;
        } else {
            $result_search['meta_keywords'][] = array();
        }
        //pre($result_search);
        return $result_search;
    }

    private function highlight($str, $search_text)
    {
        $str = strip_tags($str);
        $hl_words = '(' . $search_text . ')';
        preg_match('/(.{0,100}' . $hl_words . '.{0,100})/isu', $str, $matches);
        if (!empty($matches[1])) {
            $hl = preg_replace('/([^\s\.]*' . $hl_words . '[^\s\.]*)/iu', '<b>$1</b>', $matches[1]);
        } else {
            $hl = $str;
        }
        //$hl = '<pre>'.htmlspecialchars($hl).'</pre>';
        return $hl;
    }

    private function getLinkItem($id, $node, $alias = '')
    {
        $nodeItem = new Node($node);
        if (!empty($nodeItem->id)) {
            if ($nodeItem->getUrl() == '/main') {
                $link = '/';
            } else {
                if (!empty($alias)) {
                    $link = $nodeItem->getUrl() . '/' . $alias;
                } else {
                    if ($nodeItem->type->type != 'text') {
                        $link = $nodeItem->getUrl() . '?id=' . $id;
                    } else {
                        $link = $nodeItem->getUrl();
                    }
                }
            }
        } else {
            $link = '#';
        }
        return $link;
    }

    private function getNodeTitle($node)
    {
        $nodeItem = new AppNode($node);
        if (!empty($nodeItem->id)) {
            $ttl = $nodeItem->title;
        } else {
            $ttl = 'Заголовок не найден';
        }
        return $ttl;
    }

    private function replace_All($search_text, $replace_text, $modules, $params, $inners)
    {
        //подключаемся к БД
        $db = Registry::get('db');
        if (!empty($modules)) {
            foreach ($modules as $keyM => $valueM) {
                if (count($valueM) > 0) {
                    //у модуля есть несколько полей
                    //$keyM - имя модуля
                    foreach ($valueM as $keyYY => $valueYY) {
                        //$keyYY - имя поля
                        if (!empty($valueYY[0])) {
                            //есть итемы модуля для замены
                            $queryDB = "UPDATE `content_" . $keyM . "` SET `" . $keyYY . "` = REPLACE(" . $keyYY . ", '" . $search_text . "', '" . $replace_text . "')";
                            //pre($queryDB);
                            $db->query($queryDB);
                            $table = "content_" . $keyM;
                            pre('Проверили замену в таблице - ' . $table . ' у поля - ' . $keyYY);
                        } else {
                            //pre('нету итемов для замены');
                        }
                    }
                }
                // if (!empty($valueM[0])) {
                // 	//$valueM[0]- есть итемы модуля для замены

                // 	//$keyM - тип модуля

                // 	//content_$keyM - таблица
                // 	//$this->fields_modules_name[$keyM][0] - имя поля
                // 	//$search_text - строка для замены
                // 	//$replace_text - чем заменяем
                // 	//UPDATE ИМЯ_ТАБЛИЦЫ SET ИМЯ_ПОЛЯ = REPLACE(ИМЯ_ПОЛЯ, ‘строка для замены’, ‘чем заменяем’);
                // 	//pre("UPDATE `content_".$keyM."` SET `".$this->fields_modules_name[$keyM][0]."` = REPLACE(".$this->fields_modules_name[$keyM][0].", '".$search_text."', '".$replace_text."')");
                // 	//WHERE id>0

                // 	if (!empty($this->fields_modules_name[$keyM][0])) {
                // 		$queryDB = "UPDATE `content_".$keyM."` SET `".$this->fields_modules_name[$keyM][0]."` = REPLACE(".$this->fields_modules_name[$keyM][0].", '".$search_text."', '".$replace_text."')";
                // 		//pre($queryDB);
                // 		$db->query($queryDB);
                // 		$table = "content_".$keyM;
                // 		pre('Проверили замену в таблице - '.$table);
                // 	}
                // }
            }
        }
        if (!empty($params)) {
            foreach ($params as $keyPR => $valuePR) {
                //$valuePR[0]- есть поля для замены

                //$keyPR - название поля
                //nodes_params_values - таблица
                //$search_text - строка для замены
                //$replace_text - чем заменяем
                //pre("UPDATE `nodes_params_values` SET `value` = REPLACE(value, '".$search_text."', '".$replace_text."') WHERE `name`='".$keyPR."'");
                //WHERE id>0
                if (!empty($valuePR[0])) {
                    $queryDB = "UPDATE `nodes_params_values` SET `value` = REPLACE(value, '" . $search_text . "', '" . $replace_text . "') WHERE `name`='" . $keyPR . "'";
                    //pre($queryDB);
                    $db->query($queryDB);
                    pre('Проверили замену в таблице nodes_params_values в полях - ' . $keyPR);
                }
            }
        }
        if (!empty($inners)) {
            if (!empty($inners['before_text'][0])) {
                $query_inner = "UPDATE `nodes` SET `before_text` = REPLACE(`before_text`, '" . $search_text . "', '" . $replace_text . "')";
                //pre($query_inner);
                $db->query($query_inner);
                pre('Проверили замену в вводном тексте ДО');
            }
            if (!empty($inners['after_text'][0])) {
                $query_outer = "UPDATE `nodes` SET `after_text` = REPLACE(`after_text`, '" . $search_text . "', '" . $replace_text . "')";
                //pre($query_outer);
                $db->query($query_outer);
                pre('Проверили замену в вводном тексте ПОСЛЕ');
            }
            if (!empty($inners['meta_description'][0])) {
                $query_outer = "UPDATE `nodes` SET `meta_description` = REPLACE(`meta_description`, '" . $search_text . "', '" . $replace_text . "')";
                //pre($query_outer);
                $db->query($query_outer);
                pre('Проверили замену в ноде meta_description');
            }
            if (!empty($inners['meta_keywords'][0])) {
                $query_outer = "UPDATE `nodes` SET `meta_keywords` = REPLACE(`meta_keywords`, '" . $search_text . "', '" . $replace_text . "')";
                //pre($query_outer);
                $db->query($query_outer);
                pre('Проверили замену в ноде meta_keywords');
            }
        }
    }

}

?>