<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Event;

use Knp\Menu\MenuItem;
use Symfony\Component\EventDispatcher\Event;

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
     * Gets the root menu item.
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
