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

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\CoreBundle\Event\DisplayOptionsEvent;
use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\ThemeBundle\Form\Type\TemplateType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PageDisplayOptionsSubscriber implements EventSubscriberInterface
{
    protected $widgetAreaRepository;

    public function __construct(RepositoryInterface $widgetAreaRepository)
    {
        $this->widgetAreaRepository = $widgetAreaRepository;
    }

    public function addWidgetAreaOptions(DisplayOptionsEvent $event)
    {
        $builder = $event->getFormBuilder();

        foreach ($this->widgetAreaRepository->findAll() as $widgetArea) {
            $builder->add($widgetArea->getArea(), TemplateType::class, [
                'placeholder' => 'No Override',
                'directory' => 'WidgetArea',
                'required' => false,
                'property_path' => sprintf('[%s][template]', $widgetArea->getArea()),
            ]);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::PAGE_DISPLAY_OPTIONS => 'addWidgetAreaOptions',
        ];
    }
}
