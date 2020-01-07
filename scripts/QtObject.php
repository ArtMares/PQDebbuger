<?php


class QtObject extends PQObject
{
    private $data = 0;
    private $signature = '';
    private $history = [];

    public function setCommand($value)
    {
        $this->history[] = $value;
    }

    public function appendHistory($value)
    {
        $this->history[] = $value;
    }

    public function History()
    {
        return $this->history;
    }


}