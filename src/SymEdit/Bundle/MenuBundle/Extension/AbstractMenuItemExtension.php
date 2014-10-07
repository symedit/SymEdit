<?php

namespace SymEdit\Bundle\MenuBundle\Extension;

use Knp\Menu\ItemInterface;
use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

abstract class AbstractMenuItemExtension implements MenuExtensionInterface
{
    public function modifyMenu(MenuInterface $menu, array $options = array())
    {
        $this->recurseItem($menu->getRootNode(), $options);
    }

    protected function recurseItem(ItemInterface $item, array $options)
    {
        $this->modifyItem($item, $options);

        if ($item->hasChildren()) {
            foreach ($item->getChildren() as $child) {
                $this->recurseItem($child, $options);
            }
        }
    }

    protected function removeItem(ItemInterface $item)
    {
        $item->getParent()->removeChild($item);
    }

    protected abstract function modifyItem(ItemInterface $item, array $options);
}