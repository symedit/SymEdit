<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\EventListener;

use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\MenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class MenuSubscriber implements EventSubscriberInterface
{
    protected $context;

    public function __construct(SecurityContextInterface $context)
    {
        $this->context = $context;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::MENU_VIEW => 'viewMenu',
        );
    }

    public function viewMenu(MenuEvent $event)
    {
        // Only use main admin menu
        if ($event->getMenuName() !== 'symedit_admin') {
            return;
        }

        $rootNode = $event->getRootNode();

        if (!$rootNode->getChild('media')) {
            $media = $rootNode->addChild('media', array('label' => 'Media', 'dropdown' => true, 'caret' => true, 'icon' => 'picture'));
        } else {
            $media = $rootNode->getChild('media');
        }

        /**
         * Images
         */
        if ($this->context->isGranted('ROLE_ADMIN_IMAGE')) {
            $media->addChild('Images', array('dropdown-header' => true));
            $media->addChild('View Images', array('route' => 'admin_image', 'icon' => 'picture'));
            $media->addChild('Upload Image', array('route' => 'admin_image_create', 'icon' => 'upload'));
            $media->addChild('Galleries', array('route' => 'admin_image_gallery', 'icon' => 'film'));

            $media->addChild('Files', array('dropdown-header' => true));
            $media->addChild('View Files', array('route' => 'admin_file', 'icon' => 'file'));
            $media->addChild('Upload File', array('route' => 'admin_file_create', 'icon' => 'upload'));
        }
    }
}
