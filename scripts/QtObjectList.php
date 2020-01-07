<?php


class QtObjectList extends QWidget
{
    public function __construct($parent = null)
    {
        parent::__construct($parent);
        $this->setLayout(new QVBoxLayout());
    }

    public function addWidget($widget)
    {
        if($widget != null) $this->layout()->addWidget($widget);
    }
}