<?php


class PQObject
{
    protected $id = 0;
    protected $name = '';

    public function __construct($id = 0, $name = '')
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function __set($key, $value)
    {
        if(isset($this->{$key})) $this->{$key} = $value;
    }

    public function __get($key)
    {
        if(isset($this->{$key})) return $this->{$key};
        return null;
    }
}