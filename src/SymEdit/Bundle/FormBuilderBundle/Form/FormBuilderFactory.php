<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Form;

use SymEdit\Bundle\FormBuilderBundle\Builder\FieldBuilderRegistry;
use SymEdit\Bundle\FormBuilderBundle\Event\Events;
use SymEdit\Bundle\FormBuilderBundle\Event\FormBuilderFactoryEvent;
use SymEdit\Bundle\FormBuilderBundle\Model\FormInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

class FormBuilderFactory implements FormBuilderFactoryInterface
{
    protected $registry;
    protected $factory;
    protected $dispatcher;
    protected $router;
    protected $route;

    public function __construct
    (
        FieldBuilderRegistry $registry,
        FormFactoryInterface $factory,
        EventDispatcherInterface $dispatcher,
        RouterInterface $router, $route
    ) {
        $this->registry = $registry;
        $this->factory = $factory;
        $this->dispatcher = $dispatcher;
        $this->router = $router;
        $this->route = $route;
    }

    public function build(FormInterface $form, $data = null)
    {
        $options = [
            'label' => $form->getLegend(),
            'method' => 'POST',
            'action' => $this->router->generate($this->route, ['name' => $form->getName()]),
        ];

        // Dispatch event to tie in any options
        $event = new FormBuilderFactoryEvent($form, $options);
        $this->dispatcher->dispatch(Events::FORM_BUILD, $event);

        $builder = $this->factory->createNamedBuilder($form->getName(), FormType::class, $data, $event->getOptions());

        foreach ($form->getFormElements() as $element) {
            $fieldConfig = $this->registry->getFormElementConfig($element);

            // Fix options
            $options = $element->getOptions();
            unset($options['extra']);

            // Set constraints
            $options['constraints'] = $fieldConfig->getConstraints();

            // Add to form
            $builder->add($fieldConfig->getName(), $fieldConfig->getFormFQCN(), $options);
        }

        return $builder->getForm();
    }
}
