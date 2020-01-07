<?php


class ObjectWidget extends QWidget
{
    private $status;
    private $zClass;
    private $icon;
    private $qtClass;

    private $thread;
    private $zObject;
    private $zHandle;
    private $qtObject;

    private $history = [];
    private $log;


    public function __construct($parent = null)
    {
        parent::__construct($parent);
        $this->objectName = 'ObjectWidget';
        $this->styleSheet = '
            QWidget#ObjectWidget {
                background: transparent;
            }
            QWidget#ObjectWidget:hover {
                background: #6aa8d4;
            }
        ';
        $this->setCursor(new \QCursor(\Qt::PointingHandCursor));
        $this->initComponents();
    }

//    /** @override enterEvent */
//    public function enterEvent($event) {
//        $this->objectName = 'ObjectWidgetHover';
//        $this->styleSheet = $this->styleSheet();
//    }
//
//    /** @override leaveEvent */
//    public function leaveEvent($event) {
//        $this->objectName = 'ObjectWidget';
//        $this->styleSheet = $this->styleSheet();
//    }

    private function initComponents()
    {
        $this->setLayout(new QHBoxLayout());
        $this->layout()->setContentsMargins(3,1,3,1);

        $this->status = new Icon();
        $this->status
            ->setIcon(new QIcon(':/icons/none.svg'))
            ->setSize(new QSize(18, 18))
            ->setMaximumWidth(18);
        $this->layout()->addWidget($this->status);

        $this->zClass = new QLabel();
        $this->layout()->addWidget($this->zClass);

        $this->icon = new Icon();
        $this->icon
            ->setIcon(new QIcon(':/icons/hide.svg'))
            ->setSize(new QSize(18, 18))
            ->setMaximumWidth(18);
        $this->layout()->addWidget($this->icon);

        $this->qtClass = new QLabel();
        $this->layout()->addWidget($this->qtClass);
    }

    public function setZClass($value)
    {
        $this->zClass->text = $value." [ ".$this->zObject." ] ( ".$this->zHandle." )";
        return $this;
    }

    public function setQtClass($value)
    {
        $this->qtClass->text = $value." [ ".$this->qtObject." ]";
        return $this;
    }

    public function setThread($value)
    {
        $this->thread = $value;
        return $this;
    }

    public function setZHandle($value)
    {
        $this->zHandle = $value;
        return $this;
    }

    public function setZObject($value)
    {
        $this->zObject = $value;
        return $this;
    }

    public function setQtObject($value)
    {
        $this->qtObject = $value;
        return $this;
    }

    public function appendHistory($value)
    {
        if($value != '') {
            $this->history[] = $value;
            if($value == 'construct') $this->status->setIcon(new QIcon(':/icons/online.svg'));
            if($value == 'deleteObject') $this->status->setIcon(new QIcon(':/icons/offline.svg'));
        }
        return $this;
    }

    public function appendLog($value)
    {
        if($value != '') $this->log .= $value;
        return $this;
    }

    public function getLog()
    {
        return $this->log;
    }
}