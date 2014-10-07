<?php

namespace SymEdit\Bundle\MenuBundle\Model;

use Knp\Menu\MenuItem;

interface MenuInterface
{
    /**
     * @return MenuItem Menu Root Item
     */
    public function getRootNode();
    public function setRootNode(MenuItem $rootNode);

    public function getName();
    public function setName($name);
}
