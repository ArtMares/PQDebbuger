<?php

/**
 * @author              Dmitriy Dergachev (ArtMares)
 * @date                07.04.2017
 * @copyright           artmares@influ.su
 */
class ObjectWidget extends QWidget {
    
    private $data = [];
    
    private $ui = [];
    
    public $z_id;
    
    public $o_id;
    
    public function __construct() {
        parent::__construct(null);
        
        $this->objectName = 'ObjectWidget';
        
        $this->setLayout(new QGridLayout());
        
        $this->styleSheet = '
            QWidget#ObjectWidget {
                border: 1px solid #626262;
            }
        ';
        
        $this->initComponents();
    }
    
    public function initComponents() {
        $row = 0;
        
        $thread = new QLabel($this);
        $thread->text = 'thread:';
        $this->ui['thread'] = new QLabel($this);
        
        $this->layout()->addWidget($thread, $row, 0);
        $this->layout()->addWidget($this->ui['thread'], $row, 1);
        
        $zobject = new QLabel($this);
        $zobject->text = 'zobject:';
        $this->ui['zobject'] = new QLabel($this);
        
        $this->layout()->addWidget($zobject, $row, 2);
        $this->layout()->addWidget($this->ui['zobject'], $row, 3);
        
        $object = new QLabel($this);
        $object->text = 'object:';
        $this->ui['object'] = new QLabel($this);
        
        $this->layout()->addWidget($object, $row, 4);
        $this->layout()->addWidget($this->ui['object'], $row, 5);
        
        $row++;
        
        $zclass = new QLabel($this);
        $zclass->text = 'zclass:';
        $this->ui['zclass'] = new QLabel($this);
        
        $this->layout()->addWidget($zclass, $row, 0);
        $this->layout()->addWidget($this->ui['zclass'], $row, 1);
        
        $data = new QLabel($this);
        $data->text = 'data:';
        $this->ui['data'] = new QLabel($this);
        
        $this->layout()->addWidget($data, $row, 2);
        $this->layout()->addWidget($this->ui['data'], $row, 3);
        
        $signature = new QLabel($this);
        $signature->text = 'signature:';
        $this->ui['signature'] = new QLabel($this);
        
        $this->layout()->addWidget($signature, $row, 4);
        $this->layout()->addWidget($this->ui['signature'], $row, 5);
        
        $row++;
        
        $command = new QLabel($this);
        $command->text = 'command:';
        
        $this->layout()->addWidget($command, $row, 0, 1, 6);
        
        $row++;
        
        $this->ui['command'] = new QLabel($this);
        
        $this->layout()->addWidget($this->ui['command'], $row, 0, 1, 6);
    }
    
    public function set($key, $value) {
        if(!isset($this->data[$key])) {
            $this->ui[$key]->text = $value;
            $this->data[$key] = $value;
        } else {
            if($key == 'command') {
                $this->ui[$key]->text = $this->ui[$key]->text() . PHP_EOL . $value;
            }
        }
    }
}