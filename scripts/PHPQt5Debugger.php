<?php


class PHPQt5Debugger extends QWidget
{
    private $server;

    private $clients = [];
    /** @var Tab[] */
    private $tabs = [];

    private $widget;

    public function __construct($parent = null)
    {
        parent::__construct($parent);

        $this->initComponents();

        $this->server = new QLocalServer($this);
        $this->server->listen('PQDebugger');
        $this->server->connect(SIGNAL('newConnection()'), $this, SLOT('slot_incomingConnection()'));
    }

    private function initComponents()
    {
        $this->setLayout(new QHBoxLayout());
        $this->widget = new QTabWidget();
        $this->widget->tabsClosable = true;
        $this->widget->connect(SIGNAL('tabCloseRequested(int)'), $this, SLOT('slot_closeTab(int)'));

        $this->layout()->addWidget($this->widget);
    }

    public function slot_incomingConnection($sender)
    {
        $socket = $this->server->nextPendingConnection();
        $tab = new Tab();
        $index = $this->widget->addTab($tab, new QIcon(':/icons/online.svg'), ' ');
        $this->widget->setCurrentIndex($index);
        $this->tabs[] = $tab;

        $socket->connect(SIGNAL('readyRead()'), $this, SLOT('slot_readingData'));
        $socket->connect(SIGNAL('disconnected()'), $this, SLOT('slot_disconnectConnection()'));

        $this->clients[] = $socket;
    }

    public function slot_disconnectConnection($sender)
    {
        $index = array_search($sender, $this->clients);
        if($index !== false) {
            unset($this->clients[$index]);
            $this->widget->setTabIcon($index, new QIcon(':/icons/offline.svg'));
        }
    }

    public function slot_readingData($sender)
    {
        $index = array_search($sender, $this->clients);
        $widget = $this->tabs[$index];
        $buffer = $sender->readAll();
        $tabName = $widget->FullName();
        $pos = strpos($buffer, ":::%");
        while($pos !== false) {
            $data = explode(":::", substr($buffer, 0, $pos));
            $buffer = substr($buffer, $pos+4);

            $widget
                ->setId($data[0])
                ->setName($data[1]);
            $data[5] = str_replace(["\r", "\n"], '', $data[5]);
            $widget->readJson($this->findJson($data[5]));
//            $widget->appendLog($data[5]);
            if($tabName != $widget->FullName()) $this->widget->setTabText($index, $widget->FullName());

            $pos = strpos($buffer, ":::%");
        }
//        echo $buffer.PHP_EOL;
    }

    public function slot_closeTab($sender, $index)
    {
        if(isset($this->clients[$index])) {
            $this->clients[$index]->close();
//            unset($this->clients[$index]);
        }
        $this->widget->removeTab($index);
    }

    private function findJson($value)
    {
        $exp = new QRegExp('jsondata(\{.*\})');
        if($exp->indexIn($value) != -1) {
            return $exp->cap(1);
        }
        return false;
    }
}