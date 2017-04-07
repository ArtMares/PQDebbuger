<?php

/**
 * @author              Dmitriy Dergachev (ArtMares)
 * @date                07.04.2017
 * @copyright           artmares@influ.su
 */
class ObjectWidget extends QWidget {
    
    private $data = [];
    
    private $ui = [];
    
    private $row = 0;
    
    private $col = 0;
    
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
    }
    
    public function add($type, $value) {
        $value = (string)$value;
        if(isset($this->ui[$type])) {
            if($this->data[$type] !== $value) {
                $this->ui[$type]->text = $this->ui[$type]->text() . PHP_EOL . $value;
                $this->data[$type] = $value;
            }
        } else {
            $_type = new QLabel($this);
            $_type->text = $type;
            $this->ui[$type] = new QLabel($this);
            $this->ui[$type]->text = $value;
            $this->data[$type] = $value;
            if($this->col > 3) {
                $this->row++;
                $this->col = 0;
            }
            $this->layout()->addWidget($_type, $this->row, $this->col++);
            $this->layout()->addWidget($this->ui[$type], $this->row, $this->col++);
        }
    }
}