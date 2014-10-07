<?php

namespace SymEdit\Bundle\MenuBundle\Extension;

use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

interface MenuExtensionInterface
{
    public function modifyMenu(MenuInterface $menu, array $options = array());
}