<?php

namespace SymEdit\Bundle\CoreBundle\Model;

class Template
{
    private $layout;
    private $name;
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return \SymEdit\Bundle\CoreBundle\Model\Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }
}
