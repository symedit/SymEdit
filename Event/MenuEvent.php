<?php

namespace Isometriks\Bundle\SymEditBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Knp\Menu\MenuItem;

class MenuEvent extends Event
{
    protected $rootNode;
    protected $menuName;

    public function __construct(MenuItem $rootNode, $menuName)
    {
        $this->rootNode = $rootNode;
        $this->menuName = $menuName;
    }

    /**
     * Gets the root menu item
     *
     * @return MenuItem
     */
    public function getRootNode()
    {
        return $this->rootNode;
    }

    public function setRootNode(MenuItem $rootNode)
    {
        $this->rootNode = $rootNode;

        return $this;
    }

    public function getMenuName()
    {
        return $this->menuName;
    }
}