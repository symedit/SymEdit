<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bridge\Media\Menu;

use SymEdit\Bundle\MenuBundle\Model\MenuBuilderInterface;
use SymEdit\Bundle\MenuBundle\Model\MenuInterface;

class Builder implements MenuBuilderInterface
{
    public function buildMenu(MenuInterface $menu, array $options)
    {
        $media = $menu->getRootNode()->getChild('media');
        $imageExtras = array('is_granted' => 'ROLE_ADMIN_IMAGE');

        $media->addChild('Images', array('dropdown-header' => true, 'extras' => $imageExtras));
        $media->addChild('View Images', array('route' => 'admin_image', 'icon' => 'picture', 'extras' => $imageExtras));
        $media->addChild('Upload Image', array('route' => 'admin_image_create', 'icon' => 'upload', 'extras' => $imageExtras));
        $media->addChild('Galleries', array('route' => 'admin_image_gallery', 'icon' => 'film', 'extras' => $imageExtras));

        $media->addChild('Files', array('dropdown-header' => true, 'extras' => $imageExtras));
        $media->addChild('View Files', array('route' => 'admin_file', 'icon' => 'file', 'extras' => $imageExtras));
        $media->addChild('Upload File', array('route' => 'admin_file_create', 'icon' => 'upload', 'extras' => $imageExtras));
    }
}
