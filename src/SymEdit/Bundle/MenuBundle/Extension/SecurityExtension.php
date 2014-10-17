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
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityExtension extends AbstractMenuItemExtension
{
    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    protected function modifyItem(ItemInterface $item, array $options)
    {
        $extras = $item->getExtras();

        if (!isset($extras['is_granted'])) {
            return;
        }

        if (!$this->securityContext->isGranted($extras['is_granted'])) {
            $this->removeItem($item);
        }
    }
}
