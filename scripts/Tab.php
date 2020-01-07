<?php


class Tab extends QWidget
{
    private $id;
    private $name;
    /** @var QPlainTextEdit */
    private $log;
    /** @var QLabel */
    private $count;
    /** @var ListWidget */
    private $list;

    private $objects = [];

    private $links = [];

    public function __construct($parent = null)
    {
        parent::__construct($parent);
        $this->initComponents();
    }

    private function initComponents()
    {
        $this->setLayout(new QGridLayout());
        $this->count = new QLabel();
        $this->updateCount();
        $this->layout()->addWidget($this->count, 0, 0);

        $this->list = new ListWidget();
        $this->layout()->addWidget($this->list, 1, 0);

        $this->log = new QPlainTextEdit();
//        $this->log->readOnly = true;
        $this->layout()->addWidget($this->log, 0, 1, 2, 1);
    }

    private function updateCount()
    {
        $this->count->text = 'Objects: ' . count($this->objects);
    }

    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    public function FullName()
    {
        return $this->name . " [".$this->id."]";
    }

    public function readJson($json)
    {
        if($json !== false) {
            $this->appendLog($json->toUtf8());
            $json = Json::read($json->toUtf8());
            $ids = [];
            if(isset($json['zobject'])) $ids[] = 'zobject_'.$json['zobject'];
            if(isset($json['object'])) $ids[] = 'object_'.$json['object'];
            foreach($ids as $id) {
                if(isset($this->links[$id])) $widget = $this->links[$id];
            }
            if(!isset($widget)) {
                $widget = new ObjectWidget();
                $this->objects[] = $widget;
                $this->list->addWidget($widget);
            }
            echo 'Json: '.PHP_EOL;
            foreach($json as $key => $value) {
//                if(is_object($value)) $value = (string)$value;
                echo "--> ".$key." = ".$value->toUtf8().PHP_EOL;
                switch ($key) {
                    case 'zobject':
                        $widget->setZObject($value->toInt());
                        break;
                    case 'object':
                        $widget->setQtObject($value->toInt());
                        break;
                    case 'zclass':
                        if((string)$value !== 'PlastiQDestroyedObject') $widget->setZClass($value->toUtf8());
                        break;
                    case 'class':
                        $widget->setQtClass($value->toUtf8());
                        break;
                    case 'zhandle':
                        $widget->setZHandle($value->toInt());
                        break;
                    case 'thread':
                        $widget->setThread($value->toInt());
                        break;
                    case 'command':
                        $widget->appendHistory($value->toUtf8());
                        break;
                }
            }
            echo PHP_EOL;
            foreach($ids as $id) {
                $this->links[$id] = &$widget;
            }
            $this->updateCount();
        }
    }

    public function appendLog($value)
    {
        $this->log->appendPlainText($value);
    }
}