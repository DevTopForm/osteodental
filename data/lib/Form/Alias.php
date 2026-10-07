<?php
namespace App\Form;

use App\Node;
use App\Query;
use App\Utils;

class Alias extends Field
{

    protected $class = "text";
    protected $type = "text";

    public function setQueryValue()
    {
        if (empty(Query::$post[$this->name]) && !empty(Query::$post['title'])) {
            $this->value = $this->generateAlias(Query::$post['title']);
        } else {
            $this->value = Utils::translit(Query::$post[$this->name]);
        }
    }

    protected function generateAlias($title)
    {
        return Utils::translit($title);
    }
}