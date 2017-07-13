<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\EventsBundle\Widget\Strategy;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class UpcomingEventsWidgetStrategy extends AbstractWidgetStrategy
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('max', IntegerType::class, [
                'label' => 'Max Events',
                'help_block' => 'Maximum Events to display in Widget',
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'minMessage' => 'Minimum is 1',
                    ]),
                ],
            ])
        ;
    }

    public function execute(WidgetInterface $widget)
    {
        $maxEvents = $widget->getOption('max');
        $events = $this->repository->getUpcoming($maxEvents);

        return $this->render($widget, [
            'events' => $events,
        ]);
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'max' => 3,
            'template' => '@SymEdit/Widget/Events/upcoming-events.html.twig',
        ]);
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
