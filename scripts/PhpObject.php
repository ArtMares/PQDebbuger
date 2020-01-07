<?php


class PhpObject extends PQObject
{
    private $thread = 0;
    private $handle = 0;
    /** @var QtObject[] */
    private $qtObjects = [];

    public function count()
    {
        return count($this->qtObjects);
    }

    public function getQtObject($id, $name)
    {
        $uid = $this->getUID($id, $name);
        if(isset($this->qtObjects[$uid])) return $this->qtObjects[$uid];
        $obj = new QtObject($id, $name);
        $this->qtObjects[$uid] = $obj;
        return $obj;
    }

    private function getUID($id, $name)
    {
        return $id . "_" . $name;
    }
}