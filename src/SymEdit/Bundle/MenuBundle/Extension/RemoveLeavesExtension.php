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

class RemoveLeavesExtension extends AbstractMenuItemExtension
{
    protected function modifyItem(ItemInterface $item, array $options)
    {
        if (!$item->getExtra('remove_leaf', false)) {
            return;
        }

        if (!$item->hasChildren()) {
            $this->removeItem($item);
        }
    }
}
