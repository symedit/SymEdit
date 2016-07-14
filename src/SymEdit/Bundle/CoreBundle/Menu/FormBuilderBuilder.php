<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Menu;

use SymEdit\Bundle\MenuBundle\Model\MenuBuilderInterface;
use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

class FormBuilderBuilder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $structure = $menu->getRootNode()->getChild('structure');
        $formExtras = ['is_granted' => 'ROLE_ADMIN_FORM_BUILDER'];

        $structure->addChild('Form Builder', ['dropdown-header' => true, 'extras' => $formExtras]);
        $structure->addChild('Create Form', ['route' => 'admin_form_create', 'icon' => 'plus', 'extras' => $formExtras]);
        $structure->addCHild('List Forms', ['route' => 'admin_form', 'icon' => 'reorder', 'extras' => $formExtras]);
    }
}
