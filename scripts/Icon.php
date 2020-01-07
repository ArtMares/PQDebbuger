<?php


class Icon extends QLabel
{
    /** @var QIcon */
    private $icon;
    /** @var QSize */
    private $size;

    public function __construct($parent = null)
    {
        parent::__construct($parent);
        $this->size = new QSize(18, 18);
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        $this->updatePixMap();
        return $this;
    }

    public function setSize($size)
    {
        $this->size = $size;
        $this->updatePixMap();
        return $this;
    }

    private function updatePixMap()
    {
        $this->setPixmap($this->icon->pixmap($this->size, QIcon::Normal, QIcon::Off));
    }
}