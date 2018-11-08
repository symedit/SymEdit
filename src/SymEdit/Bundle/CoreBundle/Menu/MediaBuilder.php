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

class MediaBuilder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $media = $menu->getRootNode()->getChild('media');
        $imageExtras = ['is_granted' => 'ROLE_ADMIN_IMAGE'];

        $media->addChild('Images', ['route' => 'admin_image', 'icon' => 'image', 'extras' => $imageExtras]);
        $media->addChild('Galleries', ['route' => 'admin_image_gallery', 'icon' => 'film', 'extras' => $imageExtras]);
        $media->addChild('Files', ['route' => 'admin_file', 'icon' => 'file', 'extras' => $imageExtras]);
    }
}
