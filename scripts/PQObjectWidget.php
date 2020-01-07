<?php


class PQObjectWidget extends QWidget
{
    /** @var PQObject */
    private $pqObject;
    /** @var QtObjectList */
    private $list;

    public function __construct($parent = null)
    {
        parent::__construct($parent);

        $this->pqObject = new PQObject();

        $this->objectName = 'PQObject';
        $this->styleSheet = '
            QWidget#PQObject {
                background: transparent;
            }
            QWidget#PQObject:hover {
                background: #6aa8d4;
            }
        ';
        $this->setLayout(new QHBoxLayout());

        $name = new QLabel($this);
        $this->layout()->addWidget($name);

        $icon = new Icon();
        $icon
            ->setIcon(new QIcon(':/icons/hide.svg'))
            ->setSize(new QSize(18,18))
            ->setMaximumWidth(18);
        $this->layout()->addWidget($icon);

        $this->list = new QtObjectList();
        $this->layout()->addWidget($this->list);
    }
}