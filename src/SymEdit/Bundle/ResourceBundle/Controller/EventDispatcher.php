<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ResourceBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\EventDispatcherInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcherInterface;

/**
 * Send out generic events
 */
class EventDispatcher implements EventDispatcherInterface
{
    private $syliusEventDispatcher;
    private $symfonyEventDispatcher;

    public function __construct(EventDispatcherInterface $syliusEventDispatcher, SymfonyEventDispatcherInterface $symfonyEventDispather)
    {
        $this->syliusEventDispatcher = $syliusEventDispatcher;
        $this->symfonyEventDispatcher = $symfonyEventDispather;
    }

    public function dispatch($eventName, RequestConfiguration $requestConfiguration, ResourceInterface $resource)
    {
        $event = $this->syliusEventDispatcher->dispatch($eventName, $requestConfiguration, $resource);

        return $this->dispatchGenericEvent($event, $eventName);
    }

    public function dispatchPostEvent($eventName, RequestConfiguration $requestConfiguration, ResourceInterface $resource)
    {
        $event = $this->syliusEventDispatcher->dispatchPostEvent($eventName, $requestConfiguration, $resource);

        return $this->dispatchGenericEvent($event, 'post_'.$eventName);
    }

    public function dispatchPreEvent($eventName, RequestConfiguration $requestConfiguration, ResourceInterface $resource)
    {
        $event = $this->syliusEventDispatcher->dispatchPreEvent($eventName, $requestConfiguration, $resource);

        return $this->dispatchGenericEvent($event, 'pre_'.$eventName);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchInitializeEvent($eventName, RequestConfiguration $requestConfiguration, ResourceInterface $resource)
    {
        return $this->syliusEventDispatcher->dispatchInitializeEvent($eventName, $requestConfiguration, $resource);
    }

    private function dispatchGenericEvent(ResourceControllerEvent $event, $eventName)
    {
        $this->symfonyEventDispatcher->dispatch(sprintf('symedit.%s', $eventName), $event);

        return $event;
    }
}
