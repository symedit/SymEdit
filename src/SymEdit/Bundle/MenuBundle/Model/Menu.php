<?php

namespace SymEdit\Bundle\MenuBundle\Model;

use Knp\Menu\MenuItem;

class Menu implements MenuInterface
{
    protected $rootNode;
    protected $name;

    public function __construct(MenuItem $rootNode, $name)
    {
        $this->rootNode = $rootNode;
        $this->name = $name;
    }

    public function getRootNode()
    {
        return $this->rootNode;
    }

    public function setRootNode(MenuItem $rootNode)
    {
        $this->rootNode = $rootNode;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
