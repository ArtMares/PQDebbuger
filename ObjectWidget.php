<?php

/**
 * @author              Dmitriy Dergachev (ArtMares)
 * @date                07.04.2017
 * @copyright           artmares@influ.su
 */
class ObjectWidget extends QWidget {
    
    private $styles = [
        'deleteObject' => '
            QWidget#ObjectWidget {
                border: 1px solid #378032; border-radius: 6px; background: #87db81;
            }',
        'default' => '
            QWidget#ObjectWidget {
                border: 1px solid #6e6b16; border-radius: 6px; background: #ccc862;
            }'
    ];
    
    private $data = [];
    
    private $ui = [];
    
    public function __construct() {
        parent::__construct(null);
        
        $this->objectName = 'ObjectWidget';
        
        $this->setLayout(new QGridLayout());
        
        $this->styleSheet = $this->styles['default'];
        
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
    
        $class = new QLabel($this);
        $class->text = 'class:';
        $this->ui['class'] = new QLabel($this);
    
        $this->layout()->addWidget($class, $row, 2);
        $this->layout()->addWidget($this->ui['class'], $row, 3);
        
        $signature = new QLabel($this);
        $signature->text = 'signature:';
        $this->ui['signature'] = new QLabel($this);
        
        $this->layout()->addWidget($signature, $row, 4);
        $this->layout()->addWidget($this->ui['signature'], $row, 5);
        
        $row++;
        
        $command = new QLabel($this);
        $command->text = 'command:';
        
        $this->layout()->addWidget($command, $row, 0, 1, 2);
    
        $data = new QLabel($this);
        $data->text = 'data:';
        $this->ui['data'] = new QLabel($this);
    
        $this->layout()->addWidget($data, $row, 2);
        $this->layout()->addWidget($this->ui['data'], $row, 3);
        
        $zhandle = new QLabel($this);
        $zhandle->text = 'zhandle:';
        $this->ui['zhandle'] = new QLabel($this);
        
        $this->layout()->addWidget($zhandle, $row, 4);
        $this->layout()->addWidget($this->ui['zhandle'], $row, 5);
        
        $row++;
        
        $this->ui['command'] = new QLabel($this);
        
        $this->layout()->addWidget($this->ui['command'], $row, 0, 1, 3);
    }
    
    public function set($key, $value) {
        if(is_object($value)) $value = (string)$value;
        if(isset($this->ui[$key])) {
            if(!isset($this->data[$key])) {
                $this->ui[$key]->text = $value;
                $this->data[$key] = $value;
            } else {
                if ($key == 'command') {
                    $this->setStyle($value);
                    $this->ui[$key]->text = $this->ui[$key]->text() . PHP_EOL . $value;
                }
            }
        }
    }
    
    private function setStyle($name) {
        $this->styleSheet = (isset($this->styles[$name]) ? $this->styles[$name] : $this->styles['default']);
    }
}