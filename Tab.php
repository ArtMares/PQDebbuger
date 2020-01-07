<?php


class Tab extends QWidget
{
    protected $id;
    protected $name;
    /** @var QPlainTextEdit */
    protected $log;
    /** @var QLabel */
    protected $count;

    protected $objects = [];

    public function __construct($parent = null)
    {
        parent::__construct($parent);
        $this->initComponents();
    }

    protected function initComponents()
    {
        $this->setLayout(new QGridLayout());
        $this->count = new QLabel();
        $this->count->text = 'Objects count: ' . count($this->objects);
        $this->layout()->addWidget($this->count, 0, 0);
    }
}