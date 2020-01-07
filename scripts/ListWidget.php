<?php


class ListWidget extends QScrollArea
{
    /** @var QFrame */
    private $list;

    public function __construct($parent = null)
    {
        parent::__construct($parent);
        $this->initComponents();
    }

    private function initComponents()
    {
        $this->list = new QFrame();
        $this->list->styleSheet = 'background: transparent;';
        $this->list->setLayout(new QVBoxLayout());
        $this->list->layout()->setContentsMargins(0,0,0,0);
        $this->list->layout()->setSpacing(0);

        $listArea = new QFrame();
        $listArea->styleSheet = 'background: transparent;';
        $listArea->setLayout(new QVBoxLayout());
        $listArea->layout()->setContentsMargins(0,0,0,0);
        $listArea->layout()->setSpacing(0);
        $listArea->layout()->addWidget($this->list);

        $spacer = new QFrame();
        $spacer->styleSheet = 'background: transparent;';
        $spacer->setSizePolicy(QSizePolicy::Expanding, QSizePolicy::Expanding);
        $listArea->layout()->addWidget($spacer);

        $this->setWidget($listArea);
        $this->setWidgetResizable(true);
        $this->setHorizontalScrollBarPolicy(Qt::ScrollBarAlwaysOff);
    }

    /** @override resizeEvent */
    public function resizeEvent($e)
    {
        $this->list->setMinimumWidth($this->width());
    }

    public function addWidget($widget)
    {
        $widget->setParent($this->list);
        $this->list->layout()->addWidget($widget);
    }
}