<?php

namespace SymEdit\Bundle\UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * If you update a user's password and don't change anything else
 * the doctrine listeners won't be fired so we need to call this manually
 * just in case.
 */
class UpdatePasswordSubscriber implements EventSubscriberInterface
{
    protected $userManager;

    public function __construct(\FOS\UserBundle\Model\UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function updateUser(\Sylius\Component\Resource\Event\ResourceEvent $event)
    {
        $user = $event->getSubject();

        $this->userManager->updateUser($user);
    }

    public static function getSubscribedEvents()
    {
        return array(
            'symedit.user.pre_update' => 'updateUser',
        );
    }
}