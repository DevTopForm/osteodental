<?php

namespace App\Module;

use App\Cabinet\LoginManager;
use App\CacheManager;
use App\File;
use App\Image;
use App\Item\Comment;
use App\Message;
use App\Node;
use App\Node\Type;
use App\Query;
use App\Registry;
use App\Template;
use App\Node\Item as NodeItem;

class Model
{

    public $area = null;
    public $node = null;
    public $mainNode = null;

    public $query = [];
    public $data = [];
    public $blocks = [];
    public $params = [];
    protected Template $tpl;
    protected $title = 'Модуль';

    public static function factory($type)
    {
        $class = sprintf('%s\\%s', __NAMESPACE__, ucfirst($type));

        if (class_exists($class)) {
            return new $class();
        } else {
            $type = Type::getByKey('type', $type);

            if (!empty($type->has_content) && !empty($type->has_items)) {
                return new Listing();
            } elseif (!empty($type->has_content)) {
                return new Item();
            } else {
                return new self();
            }
        }
    }

    public function __construct()
    {
        $this->tpl = new Template();
    }

    protected function can_cache()
    {
        return false;
    }

    public function getContent()
    {
        $setting = Registry::get('settings')->getSiteParams();
        if (!empty($setting['cache'])) {
            $can_cache = $this->can_cache();
        } else {
            $can_cache = 0;
        }
        if ($can_cache) {
            $cm = CacheManager::getInstance();
            $cache_id = $this->getCacheId();
            $content = $cm->getCache($cache_id);
            if (empty($this->area)) {
                //кэш мета-данных
                //$this->mainNode->meta_title       = $cm->getCache($cache_id.'_t');
                //$this->mainNode->meta_keywords    = $cm->getCache($cache_id.'_k');
                //$this->mainNode->meta_description = $cm->getCache($cache_id.'_d');
                //кэш соц данных (fb)
                $this->mainNode->og_title = $cm->getCache($cache_id . '_ogt');
                $this->mainNode->og_description = $cm->getCache($cache_id . '_ogd');
                $this->mainNode->og_text = $cm->getCache($cache_id . '_ogtx');
                $this->mainNode->og_image = $cm->getCache($cache_id . '_ogi');
                //if(isset(Query::$get['debug'])){
                //	pre('из кэша', $this->node->type->type, $cache_id, $this->mainNode->meta_title, $this->node->meta_keywords, $this->mainNode->meta_description);
                //}
            }
        }
        if (empty($content) || !$can_cache) {
            $this->title = $this->node->title;
            $this->tpl->assign('content', $this->prepareContent());
            $this->tpl->assign($this->data);
            $this->tpl->assign('params', $this->params);
            $this->tpl->assign('node', $this->node);
            $this->tpl->assign('blocks', $this->blocks);
            try {
                $this->tpl->assign('user', LoginManager::getLoggedUser());
            } catch (\Exception $e) {
            }
            $this->tpl_file = empty($this->tpl_file) ? ('module/' . $this->node->getType() . '/' . $this->getTemplate(
                )) : $this->tpl_file;
            $content = $this->tpl->fetch($this->tpl_file);
            if ($can_cache) {
                $cm->setCache($cache_id, $content);
                if (empty($this->area)) {
                    //кэш мета-данных
                    //$cm->setCache($cache_id.'_t', $this->mainNode->meta_title);
                    //$cm->setCache($cache_id.'_k', $this->mainNode->meta_keywords);
                    //$cm->setCache($cache_id.'_d', $this->mainNode->meta_description);
                    //кэш соц данных (fb)
                    $cm->setCache($cache_id . '_ogt', $this->mainNode->og_title);
                    $cm->setCache($cache_id . '_ogd', $this->mainNode->og_description);
                    $cm->setCache($cache_id . '_ogtx', $this->mainNode->og_text);
                    $cm->setCache($cache_id . '_ogi', $this->mainNode->og_image);
                    //if(isset(Query::$get['debug'])){
                    //	pre('Сгенерирован', $this->node->type->type, $cache_id, $this->mainNode->meta_title, $this->mainNode->meta_keywords, $this->mainNode->meta_description);
                    //}
                }
            }
        }
        return $content;
    }

    protected function getTemplate()
    {
        if (is_null($this->area)) {
            return $this->node->getTemplate();
        } else {
            return $this->area->getTemplate();
        }
    }

    protected function getCacheId()
    {
        $url = parse_url($_SERVER['REQUEST_URI']);
        if (isset($url['query'])) {
            parse_str($url['query'], $get);
        }
        $item = '';
        if (empty($this->area->area) && ($this->node->url != $url['path'])) {
            $parsed_url = explode('/', $url['path']);
            $item = array_pop($parsed_url);
            $item = preg_replace("/[^a-zA-Z0-9\s]/", "_", $item);
            $item = 'alias_' . $item;
        } elseif (empty($this->area->area) && isset($get['id'])) {
            $item = 'id_' . (int)$get['id'];
        } elseif (empty($this->area->area) && isset($get['page'])) {
            $item = 'page_' . (int)$get['page'];
        }
        return sprintf(
            'content_%s_%s_%s_%s',
            $this->node->getType(),
            $this->node->id,
            empty($this->area) ? 0 : $this->area->area,
            $item
        );
    }

    public function prepareContent()
    {
        if (!is_null($this->node)) {
            return $this->node->getContent();
        }
        return '';
    }

    public function getTitle()
    {
        return $this->title;
    }

    protected function addComment($item)
    {
        try {
            $this->data['user'] = LoginManager::getLoggedUser();
        } catch (\Exception $e) {
            $this->data['user'] = null;
        }
        if (!empty(Query::$post['send-comment'])) {
            $comment = new Comment();
            $comment->node = $this->node;
            $comment->item = $item;
            $comment->date = time();
            $comment->text = strip_tags(Query::$post['text']);
            $comment->public = empty($this->params['comment_moderation']) ? 1 : 0;
            $comment->parent = empty(Query::$post['parent']) ? 0 : (int)Query::$post['parent'];
            $errors = [];
            if (empty($this->data['user'])) {
                $comment->name = strip_tags(Query::$post['name']);
                $comment->company = strip_tags(Query::$post['company']);
                $comment->position = strip_tags(Query::$post['position']);
                if (empty(Query::$post['captcha']) || (Query::$post['captcha'] != $_SESSION['captcha_comment'])) {
                    $errors[] = new Message('Проверочный код заполнен неверно', 'error');
                }
            } else {
                $comment->user = $this->data['user'];
            }
            if ($comment->validate() && empty($errors)) {
                $comment->save();
                if (!empty($this->params['comment_notification'])) {
                    $comment->notify();
                }
                $result = [
                    'status' => 'success',
                    'message' => [
                        new Message(
                            empty($this->params['comment_moderation']) ? 'Отзыв успешо добавлен' : 'Ваш отзыв появится на сайте после модерации',
                            'success'
                        )
                    ]
                ];
                if (empty($this->params['comment_moderation'])) {
                    $result['url'] = $item->url;
                }
            } else {
                $result = [
                    'status' => 'error',
                    'message' => array_merge($comment->errors, $errors)
                ];
            }
            echo json_encode($result);
            die;
        }
    }

    protected function getComments($object, $item)
    {
        $list = Comment::getItemComments($object->id, $item->id)->getItems();
        $data = [];
        foreach ($list as $comment) {
            if (empty($comment->public)) {
                continue;
            }
            $data[$comment->id] = $comment;
        }
        return $this->prepareCommentsTree($data);
    }

    protected function prepareCommentsTree($array)
    {
        $tree = [];
        foreach ($array as $key => $item) {
            $current = &$array[$item->id];
            if (empty($item->parent)) {
                $tree[$item->id] = &$current;
            } else {
                $array[$item->parent]->childs[$item->id] = &$current;
            }
        }
        return $tree;
    }

    public static function getItemsFromTable(
        string $table,
        array $params = ["filters" => [], "sorters" => []],
        int $limiter = null
    ): array {
        \App\Node\Item::$itemsTable = $table;
        $items = \App\Node\Item::getList($params, $limiter)->getItems();
        return self::prepareItems($items);
    }

    public static function prepareItems(array $items): array
    {
        foreach ($items as $item) {
            $images = ["image", "bg"];
            foreach ($images as $imageField) {
                if (!empty($item->$imageField) && !is_object($item->$imageField)) {
                    $item->$imageField = new Image($item->$imageField);
                }
            }

            $files = ["video"];
            foreach ($files as $fileField) {
                if (!empty($item->$fileField) && !is_object($item->$fileField)) {
                    $item->$fileField = new File($item->$fileField);
                }
            }

            if ($item->gallery) {
                if (!is_array($item->gallery)) {
                    $item->gallery = explode(';', $item->gallery);
                    $imgs = [];
                    foreach ($item->gallery as $key => $imgId) {
                        if (!empty($imgId)) {
                            $img = new Image($imgId);
                            if ($img->id) {
                                $imgs[] = $img;
                            }
                        }
                    }

                    $item->gallery = $imgs;
                }
            }
        }

        return $items;
    }

    public static function getListByIDs(string $IDs, string $table, string $class_name): array
    {
        $result = [];

        if(
            !empty($IDs)
        ) {
            NodeItem::$itemsTable = $table;
            $result = NodeItem::getList([
                'filters' => [
                    'public = 1',
                    sprintf('id IN (%s)', $IDs)
                ],
                'sorters' => [
                    'sorter ASC'
                ]
            ])->getItems();
        }

        return array_map([$class_name, 'prepareItem'], $result);
    }

    protected static function getStaffByIDs(string $IDs): array
    {
        return self::getListByIDs($IDs, 'content_staff', Staff::class);
    }

    protected static function getEquipmentByIDs(string $IDs): array
    {
        return self::getListByIDs($IDs, 'content_equipment', Equipment::class);
    }

    protected static function getPricesByIDs(string $IDs): array
    {
        return self::getListByIDs($IDs, 'content_prices', Prices::class);
    }

    protected static function getResultsByIDs(string $IDs): array
    {
        return self::getListByIDs($IDs, 'content_results', Results::class);
    }

    protected static function getStocksByIDs(string $IDs): array
    {
        return self::getListByIDs($IDs, 'content_stocks', Stocks::class);
    }

    protected static function getNewsByIDs(string $IDs): array
    {
        return self::getListByIDs($IDs, 'content_news', News::class);
    }

    protected static function getServicesByIDs(string $IDs): array
    {
        $result = [];

        if(
            !empty($IDs)
        ) {
            $result = Node::getList([
                'filters' => [
                    'public = 1',
                    sprintf('id IN (%s)', $IDs)
                ],
                'sorters' => [
                    'weight ASC'
                ]
            ])->getItems();
        }

        return array_map([Services::class, 'prepareItem'], $result);
    }

    protected static function getServicesByParent($parent): array
    {
        $result = [];

        if(
            !empty($parent)
        ) {
            $result = Node::getList([
                'filters' => [
                    'public = 1',
                    sprintf('parent = %s', $parent)
                ],
                'sorters' => [
                    'weight ASC'
                ]
            ])->getItems();
        }

        return array_map([Services::class, 'prepareItem'], $result);
    }


    public function setBlock($alias, $content)
    {
        $this->blocks[$alias] = $content;
    }
}