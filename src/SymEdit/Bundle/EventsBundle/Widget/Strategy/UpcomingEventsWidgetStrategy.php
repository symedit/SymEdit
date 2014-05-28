<?php

namespace SymEdit\Bundle\EventsBundle\Widget\Strategy;

use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;

class UpcomingEventsWidgetStrategy extends AbstractWidgetStrategy
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(WidgetInterface $widget)
    {
        $maxEvents = $widget->getOption('max_events');
        $events = $this->repository->getUpcomingEvents($widget, $maxEvents);

        $this->render('@SymEdit/Widget/Events/upcoming_events.html.twig', array(
            'events' => $events,
        ));
    }

    public function getDescription()
    {
        return 'events.upcoming_events';
    }

    public function getName()
    {
        return 'upcoming_events';
    }
}