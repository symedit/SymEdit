<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
