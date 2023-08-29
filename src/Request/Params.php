<?php
namespace agregalel\router_php\Request;

class Params
{
    private $params = array();

    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function __get($name)
    {
        return $this->params[$name];
    }

    public function exist($param = '')
    {
        return isset($this->params[$param]);
    }
}
