<?php

namespace App;

use App\Site\Setting\Item;
use App\Node\Setting\Item as NodeSettingItem;

class Setting
{

    protected $global = [];
    protected $local = [];
    protected $blocks = [];

    public static $cache_id = 'site_settings';

    public function __construct()
    {
        $this->getSettings();
    }

    private function getSettings($refresh = false)
    {
        $cm = CacheManager::getInstance();
        if ($refresh) {
            $cm->removeCache(self::$cache_id);
            CacheManager::clear_content();
        }
        $settings = $cm->getCache(self::$cache_id);
        if (empty($settings)) {
            $this->getSettingsData();
            $settings = [
                'global' => $this->global,
                'local' => $this->local,
                'blocks' => $this->blocks,
            ];
            $cm->setCache(self::$cache_id, serialize($settings));
        } else {
            $settings = @unserialize($settings);
            if (!empty($settings)) {
                $this->global = $settings['global'];
                $this->local = $settings['local'];
                $this->blocks = $settings['blocks'];
            } else {
                $this->getSettingsData();
                $settings = [
                    'global' => $this->global,
                    'local' => $this->local,
                    'blocks' => $this->blocks,
                ];
                $cm->setCache(self::$cache_id, serialize($settings));
            }
        }
    }

    public function update()
    {
        $this->getSettings(true);
    }

    private function getSettingsData()
    {
        $this->global = Item::get('assoc');
        $this->local = [];
        $local = NodeSettingItem::get('list');
        //pre($local);
        foreach ($local as $item) {
            $key = sprintf('%s::%s::%s', $item->type, $item->node, $item->area);
            if (!isset($this->local[$key])) {
                $this->local[$key] = [];
            }
            $this->local[$key][$item->name] = $item->value;
        }
    }

    public function getSiteParams($name = '')
    {
        if (!empty($name)) {
            return isset($this->global[$name]) ? $this->global[$name] : null;
        } else {
            return $this->global;
        }
    }

    public function getNodeParams($node, $area = 0, $name = '')
    {
        $params = $this->global;
        $rootkey = sprintf('%s::%s::%s', $node->type->type, empty($node->id) ? 0 : $node->id, 0);
        $localkey = sprintf('%s::%s::%s', $node->type->type, empty($node->id) ? 0 : $node->id, $area);
        $modulekey = sprintf('%s::0::0', $node->type->type);
        if (isset($this->local[$modulekey])) {
            $params = array_merge($params, $this->local[$modulekey]);
        }

        if (empty($name)) {
            if (isset($this->local[$rootkey])) {
                $params = array_merge($params, $this->local[$rootkey]);
            }

            if (!empty($area) && isset($this->local[$localkey])) {
                $params = array_merge($params, $this->local[$localkey]);
            }

            return $params;
        } else {
            if (isset($this->local[$rootkey][$name])) {
                $value = $this->local[$rootkey][$name];
            }
            if (!empty($area) && isset($this->local[$localkey][$name])) {
                $value = $this->local[$rootkey][$name];
            }
            return $value;
        }
    }

    public function getBlockParams($block, $area = 0)
    {
        $params = $this->global;
        $key = sprintf('%s::%s', $block, $area);
        if (!empty($area) && isset($this->blocks[$key])) {
            $params = array_merge($params, $this->blocks[$key]);
        }
        return $params;
    }

}

?>
