<?php

/**
 * @author              Dmitriy Dergachev (ArtMares)
 * @date                07.04.2017
 * @copyright           artmares@influ.su
 */
class PQDebugger extends QWidget {
    
    private $server;
    
    private $sockets = [];
    
    private $clients = [];
    
    private $tabs;
    
    private $debugBuffer;
    
    public function __construct($parent = null) {
        parent::__construct($parent);
        
        $this->initComponents();
        
        $this->server = new QLocalServer($this);
        $this->server->listen('PQDebugger');
        $this->server->connect(SIGNAL('newConnection()'), $this, SLOT('incomingConnection()'));
    }
    
    private function initComponents() {
        $this->tabs = new QTabWidget($this);
        $this->tabs->tabsClosable = true;
        $this->tabs->connect(SIGNAL('tabCloseRequested(int)'), $this, SLOT('tabClose(int)'));
        
        $this->setLayout(new QVBoxLayout());
        $this->layout()->addWidget($this->tabs);
    }
    
    public function incomingConnection() {
        $socket = $this->server->nextPendingConnection();
        $socket->connect(SIGNAL('readyRead()'), $this, SLOT('readDebugData()'));
        $socket->connect(SIGNAL('disconnected()'), $this, SLOT('disconnectConnection()'));
        
        $this->sockets[] = $socket;
    }
    
    public function disconnectConnection($sender) {
        $index = array_search($sender, $this->sockets);
        if($index !== false) unset($this->sockets[$index]);
    }
    
    public function tabClose($sender, $index) {
        if(isset($this->clients[$index])) {
            unset($this->clients[$index]);
        }
        $this->tabs->removeTab($index);
    }
    
    public function readDebugData($sender) {
        $this->debugBuffer = $sender->readAll();
        
        $pos = strpos($this->debugBuffer, ":::%");
        
        while($pos !== false) {
            $info = explode(":::", substr($this->debugBuffer, 0, $pos));
            $this->debugBuffer = substr($this->debugBuffer, $pos+4);
            
            $clientEngineId = $info[0];
            $clientAppCoreName = $info[1];
            $thread = $info[2];
            $debugLevel = $info[3];
            $debugTitle = $info[4];
            $debugMessage = str_replace(["\r", "\n"], '', $info[5]);
            
            $this->addToTab($clientEngineId, $clientAppCoreName, $debugMessage, $this->findJson($debugMessage));
            
            $pos = strpos($this->debugBuffer, ":::%");
        }
    }
    
    private function addToTab($id, $name, $log, $json) {
        if(!isset($this->clients[$id])) {
            $client = new stdClass();
            $client->log = new QPlainTextEdit();
            $client->log->readOnly = true;
            
            $client->list = new ListWidget();
            
            $client->count = new QLabel();
            
            $client->objects = [];
            $client->links = [];
            $client->json = [];
            
            $client->widget = new QWidget();
            $client->widget->setLayout(new QGridLayout());
            $client->widget->layout()->addWidget($client->list, 1, 0);
            $client->widget->layout()->addWidget($client->count, 0, 0);
            $client->widget->layout()->addWidget($client->log, 0, 1, 2, 1);
            
            $tabIndex = $this->tabs->addTab($client->widget, "$name [$id]");
            $this->tabs->setCurrentIndex($tabIndex);
            
            $client->index = $tabIndex;
            
            $this->clients[$id] = $client;
        } else {
            $client = $this->clients[$id];
        }
        if($json !== false) {
            
            $json = Json::read($json->toUtf8());
            $tmp = [
                'thread' => ' ',
                'zhandle' => ' ',
                'zobject' => ' ',
                'object' => ' ',
                'zclass' => ' ',
                'data' => ' ',
                'command' => ' ',
                'signature' => ' '
            ];
            $ids = [];
            foreach($json as $key => $value) {
                if($key == 'zobject' || $key == 'object') $ids[] = $key.'_'.$value;
                $tmp[$key] = $value;
            }
            foreach($ids as $id) {
                if($this->checkObject($id, $client->links)) {
                    $widget = $client->links[$id];
                }
            }
            if(!isset($widget)) {
                $widget = new ObjectWidget();
                $client->objects[] = $widget;
                $client->list->addWidget($widget);
                $client->count->text = 'Objects count: '.count($client->objects);
            }
            foreach($ids as $id) {
//                if(substr_count('zobject', $id) > 0) {
//                    if(is_null($widget->z_id)) {
//                        $widget->z_id = $id;
//                    }
//                }
//                if(substr_count('object', $id) > 0) {
//                    if(is_null($widget->o_id)) {
//                        $widget->o_id = $id;
//                    }
//                }
                $client->links[$id] = &$widget;
            }
            foreach($tmp as $key => $value) $widget->set($key, $value);
        } else {
            $client->log->appendPlainText($log);
        }
    }
    
    private function checkObject($needle, &$array) {
        if(!isset($array[$needle])) return false;
        return true;
    }
    
    private function findJson($msg) {
        $exp = new QRegExp('jsondata(\{.*\})');
        if($exp->indexIn($msg) != -1) {
            return $exp->cap(1);
        }
        return false;
    }
}