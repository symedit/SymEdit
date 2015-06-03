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
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityExtension extends AbstractMenuItemExtension
{
    protected $auth;

    public function __construct(AuthorizationCheckerInterface $auth)
    {
        $this->auth = $auth;
    }

    protected function modifyItem(ItemInterface $item, array $options)
    {
        $extras = $item->getExtras();

        if (!isset($extras['is_granted'])) {
            return;
        }

        if (!$this->auth->isGranted($extras['is_granted'])) {
            $this->removeItem($item);
        }
    }
}
