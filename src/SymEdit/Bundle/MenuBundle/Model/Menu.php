<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
