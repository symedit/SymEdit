<?php

namespace SymEdit\Bundle\SeoExportBundle\EventListener;

use Isometriks\Bundle\SymEditBundle\Event\Events;
use Isometriks\Bundle\SymEditBundle\Event\MenuEvent;
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
        $content = $rootNode->getChild('Site');

        /**
         * No content, might not have permissions
         */
        if ($content === null || !$this->context->isGranted('ROLE_SUPER_ADMIN')) {
            return;
        }

        $content->addChild('SEO Export', array(
            'icon' => 'search',
            'route' => 'symedit_seo_export',
        ));
    }
}