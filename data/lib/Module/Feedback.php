<?php

namespace App\Module;

use App\Field;
use App\Query;
use App\Item\Feedback as ItemFeedback;

class Feedback extends Model
{

    protected $sorter = 'sorter';
    protected $sortorder = 'ASC';

    protected function can_cache()
    {
        if (
            !empty(Query::$post['send'])
            && isset(Query::$post['areaform'])
            && (Query::$post['areaform'] == (empty($this->area) ? 0 : $this->area->area))
        ) {
            return false;
        }
        return true;
    }

    public function prepareContent()
    {
        $this->params = $this->node->getParams(empty($this->area) ? 0 : $this->area->area);
        $this->params['area'] = empty($this->area) ? 0 : $this->area->area;
        $rs = $this->prepareList($this->params);
        $this->items = $rs->getItems();
        $this->data['area_id'] = empty($this->area) ? 0 : $this->area->area;
        $this->data['mainNode'] = $this->mainNode;

        if (empty($this->area)) {
            $this->mainNode->meta_title = $this->node->meta_title;
            $this->mainNode->meta_keywords = $this->node->meta_keywords;
            $this->mainNode->meta_description = $this->node->meta_description;
        }

        if (isset(Query::$post['catalog_id']) && !empty(Query::$post['catalog_id'])) {
            $this->catalog_id = Query::$post['catalog_id'];
        }

        if (!empty(Query::$post['send']) && isset(Query::$post['areaform']) && (Query::$post['areaform'] == $this->data['area_id'])) {
            $feedback = new ItemFeedback();
            $feedback->node = $this->node;
            $feedback->ip = $_SERVER['REMOTE_ADDR'];
            $feedback->date = time();

            if (isset($this->catalog_id) && !empty($this->catalog_id)) {
                $feedback->catalog_id = $this->catalog_id;
            }

            $feedback->setFields($this->items);
            if ($feedback->validate()) {
                $feedback->save();
                $feedback->notify();
                $this->data['done'] = empty($this->params['donemess']) ? 'Ваше сообщение отправлено' : $this->params['donemess'];
            } else {
                $this->data['errors'] = $feedback->errors;
            }
        }

        $this->data['ajax'] = empty(Query::$get['ajax']) ? 0 : 1;
        $this->data['content'] = $this->items;

        if (!empty(Query::$post['ajreq']) && isset(Query::$post['areaform']) && (Query::$post['areaform'] == $this->data['area_id'])) {
            header('Content-Type: application/json; charset=utf-8');

            if (empty($this->data['errors'])) {
                echo json_encode(array(
                    'status' => true,
                    'message' => '<p class="success">' . empty($this->data['done']) ? 'Ваше сообщение отправлено' : $this->data['done'] . '</p>',
                ));
            } else {
                echo json_encode(array(
                    'status' => false,
                    'errors' => $this->data['errors']
                ));
            }
            die;
        }
    }

    protected function prepareList($params = array())
    {
        if (!empty($this->params['pager'])) {
            $params['pager'] = $this->params['pager'];
        }

        $params['filters'][] = "public = 1";
        $params['sorters'] = array(sprintf('%s %s', $this->sorter, $this->sortorder));
        $rs = $this->node->getItems($params);
        $items = array();

        foreach ($rs->getItems() as $item) {
            $preItem = $this->prepareInList($item, $this->params);
            $preItem->type = $preItem->field->getTypeField();
            $preItem->field->type = $preItem->field->getTypeField();
            $items[] = $preItem;
        }

        $rs->setItems($items);

        return $rs;
    }

    protected function prepareInList($item, $params = null)
    {
        $item->name = sprintf("field_%s_area_%s", $item->id, $params['area']);
        $item->field = new Field($item);

        return $item;
    }


    protected function validate()
    {
        $valid = true;
        $this->messages = array();
        foreach ($this->items as $key => $item) {
            $messages = $item->field->validate();
            if (!empty($messages)) {
                $valid = false;
                $this->messages = array_merge($this->messages, $messages);
            }
            $this->items[$key]->field = $item->field;
        }

        return $valid;
    }
}