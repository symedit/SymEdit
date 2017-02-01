<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\EventListener;

use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use SymEdit\Bundle\SeoBundle\Model\SeoManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SymEditSubjectSubscriber implements EventSubscriberInterface
{
    protected $seoManager;
    protected $preferences;

    public function __construct(SeoManagerInterface $seoManager, array $preferences = [])
    {
        $this->seoManager = $seoManager;
        $this->preferences = $preferences;
    }

    public function onSymEditShow(ResourceControllerEvent $event)
    {
        $subject = $event->getSubject();

        if ($this->hasModel($subject)) {
            $this->seoManager->setSubject($subject);
        }
    }

    protected function hasModel($subject)
    {
        foreach ($this->preferences as $preference) {
            $model = $preference->getModel();

            if ($subject instanceof $model) {
                return true;
            }
        }

        return false;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'symedit.show' => 'onSymEditShow',
        );
    }
}
