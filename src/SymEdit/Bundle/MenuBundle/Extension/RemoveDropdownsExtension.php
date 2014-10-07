<?php

namespace SymEdit\Bundle\MenuBundle\Extension;

use Knp\Menu\ItemInterface;

class RemoveDropdownsExtension extends AbstractMenuItemExtension
{
    protected function modifyItem(ItemInterface $item, array $options)
    {
        if (!$item->getExtra('remove_dropdown', false)) {
            return;
        }

        if (!$item->hasChildren()) {
            $this->removeItem($item);
        }
    }
}
