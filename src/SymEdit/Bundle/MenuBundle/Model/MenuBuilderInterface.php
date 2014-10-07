<?php

namespace SymEdit\Bundle\MenuBundle\Model;

interface MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options);
}
