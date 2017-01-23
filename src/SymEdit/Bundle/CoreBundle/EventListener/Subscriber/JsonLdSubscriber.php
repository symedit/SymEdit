<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\EventListener\Subscriber;

use Isometriks\Bundle\JsonLdDumperBundle\RegistryInterface;
use Isometriks\JsonLdDumper\MappingConfiguration;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JsonLdSubscriber implements EventSubscriberInterface
{
    private $registry;
    private $mappingConfiguration;

    public function __construct(RegistryInterface $registry, MappingConfiguration $mappingConfiguration)
    {
        $this->registry = $registry;
        $this->mappingConfiguration = $mappingConfiguration;
    }

    public function onSymEditShow(ResourceControllerEvent $event)
    {
        $subject = $event->getSubject();

        if ($this->mappingConfiguration->hasEntityMapping($subject)) {
            $this->registry->register($subject);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'symedit.show' => 'onSymEditShow',
        ];
    }
}
