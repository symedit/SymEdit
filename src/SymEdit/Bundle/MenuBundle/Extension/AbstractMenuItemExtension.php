<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MenuBundle\Extension;

use Knp\Menu\ItemInterface;
use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

abstract class AbstractMenuItemExtension implements MenuExtensionInterface
{
    public function modifyMenu(MenuInterface $menu, array $options = [])
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

    abstract protected function modifyItem(ItemInterface $item, array $options);
}
