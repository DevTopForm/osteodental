<?php
namespace App;

class Structure
{
    private static $instance = null;

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private $table = 'nodes';
    private $raw_data = null;
    private $tree = array();
    private $flat_tree = array();

    private function __construct()
    {
        $this->get_raw_data();
        //pre($this->get_flat_tree());
        //pre($this->get_tree());
    }

    private function __clone()
    {
    }

    public function clear_cache()
    {
        $this->raw_data = null;
        $this->tree = array();
    }

    public function get_raw_data($parent = null)
    {
        $parent = ($parent === null) ? -1 : (int)$parent;
        $db = Registry::get('db');
        if ($this->raw_data === null) {
            $raw = Node::getStructure();
            if ($raw !== null) {
                $raw_nodes = array();
                $expanded_nodes = explode(
                    ',',
                    (string)(empty($_COOKIE['expanded_nodes']) ? '' : $_COOKIE['expanded_nodes'])
                );
                foreach ($raw as $raw_node) {
                    $raw_node['expanded'] = in_array($raw_node['id'], $expanded_nodes);
                    $raw_nodes[$raw_node['id']] = $raw_node;
                }
                $this->raw_data = array(-1 => $raw_nodes);
            }
        }

        if (isset($this->raw_data[$parent])) {
            $nodes = $this->raw_data[$parent];
        } else {
            $raw = $this->raw_data[-1];
            $nodes = array();

            foreach ($raw as $node) {
                if ($node['parent'] == $parent) {
                    $node['url'] = $this->get_url($node['id']);
                    $nodes[$node['id']] = $node;
                }
            }
            $this->raw_data[$parent] = $nodes;
        }
        return (count($nodes) > 0) ? $nodes : array();
    }

    public function get_tree($parent = null)
    {
        $parent = (int)$parent;
        $tree = null;
        if (isset($this->tree[$parent])) {
            $tree = $this->tree[$parent];
        } else {
            $nodes = $this->get_raw_data($parent);
            if ($nodes !== null) {
                $tree = array();
                foreach ($nodes as $node) {
                    $node['childs'] = $this->get_tree($node['id']);
                    $tree[$node['id']] = $node;
                }
                $this->tree[$parent] = $tree;
            }
        }
        return $tree;
    }

    public function get_tree_with_item($parent = null)
    {
        $parent = (int)$parent;
        $tree = null;
        if (isset($this->tree[$parent])) {
            $tree = $this->tree[$parent];
        } else {
            $nodes = $this->get_raw_data($parent);
            if ($nodes !== null) {
                $tree = array();
                foreach ($nodes as $node) {
                    $nodeObj = new Node($node['id']);
                    $items = $nodeObj->getItems()->getItems();

                    if (empty($items)) {
                        continue;
                    }

                    $node["item"] = array_shift($items);

                    $node['childs'] = $this->get_tree_with_item($node['id']);
                    $tree[$node['id']] = $node;
                }
                $this->tree[$parent] = $tree;
            }
        }
        return $tree;
    }

    public function get_flat_tree($parent = null)
    {
        $parent = (int)$parent;
        $tree = null;
        if (isset($this->flat_tree[$parent])) {
            $tree = $this->flat_tree[$parent];
        } else {
            $nodes = $this->get_raw_data($parent);
            if ($nodes !== null) {
                $tree = array();
                foreach ($nodes as $node) {
                    $tree[$node['id']] = $node;
                    $childs = $this->get_flat_tree($node['id']);
                    if (count($childs) > 0) {
                        foreach ($childs as $child) {
                            $tree[$child['id']] = $child;
                        }
                    }
                }
                $this->flat_tree[$parent] = $tree;
            }
        }
        return $tree;
    }

    public function get_path($nid = null)
    {
        $path = null;
        $nid = (int)$nid;
        $nodes = $this->get_raw_data();
        if (($nid > 0) && isset($nodes[$nid])) {
            $node = $nodes[$nid];
            $path = array($node);
            while ($node['parent'] > 0) {
                $node = $nodes[$node['parent']];
                $path[] = $node;
            }
            $path = array_reverse($path);
        }

        return $path;
    }

    public function get_node_by_id($nid = null)
    {
        $node = null;
        $nid = (int)$nid;
        $nodes = $this->get_raw_data();
        if (($nid > 0) && isset($nodes[$nid])) {
            $node = $nodes[$nid];
        }
        return $node;
    }

    public function get_node_by_alias($alias = '', $parent = null)
    {
        //$alias = field::string(trim($alias));
        //$parent = (int) $parent;
        $nodes = $this->get_raw_data($parent);
        //pre('recieved',$alias,$parent === null);
        foreach ($nodes as $node) {
            //pre($node['alias'],);
            if ($node['alias'] == $alias && (($parent !== null && $node['parent'] == $parent) || $parent === null)) {
                return $node;
                break;
            }
        }

        return null;
    }

    public function get_node_by_url($url = '', $ret_main = true)
    {
        $url_parts = parse_url('/' . $url);
        if (isset($url_parts['path'])) {
            $steps = array_diff(explode('/', $url_parts['path']), array(''));
            if (count($steps) > 0) {
                $node = array('id' => 0);
                foreach ($steps as $i => $step) {
                    $node = $this->get_node_by_alias($step, $node['id']);
                    if ($node === null) {
                        if (isset($prevnode) && !empty($prevnode['alias'])) {
                            $nn = new Node($prevnode['id']);

                            $n_fields = \App\Node\Field::getFieldByKey($nn->type->type, 'alias');
                            if ($n_fields == 0) {
                                if ($prevnode['alias'] != $step) {
                                    return null;
                                }
                                return $prevnode;
                            }
                            $item = \App\Node\Item::getByAlias(strip_tags($step), $nn);
                            if (!empty($item)) {
                                return $prevnode;
                            } elseif ($nn->id == 3546) {
                                return $prevnode;
                            }
                        }
                        return null;
                    } else {
                        $prevnode = $node;
                    }
                }
                return $node;
            } elseif ($ret_main) {
                return $this->get_main_node();
            }
        }
        return null;
    }

    public function get_url($nid = null)
    {
        $nid = (int)$nid;
        $url = array();

        $nodes = $this->get_raw_data();

        if (($nid > 0) && isset($nodes[$nid])) {
            $node = $nodes[$nid];
            $url[] = $node['alias'];

            while ($node['parent'] > 0) {
                $node = $nodes[$node['parent']];
                $url[] = $node['alias'];
            }

            $url = array_reverse($url);
        }

        return '/' . implode('/', $url);
    }

    public function get_main_node()
    {
        $nodes = $this->get_raw_data();

        foreach ($nodes as $node) {
            if ($node['main'] == 1) {
                return $node;
            }
        }

        return null;
    }

}

?>
