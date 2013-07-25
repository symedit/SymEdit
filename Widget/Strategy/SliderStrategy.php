<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Symfony\Component\Form\FormBuilderInterface;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class SliderStrategy extends AbstractWidgetStrategy
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function execute(WidgetInterface $widget)
    {
        $request = $this->container->get('request');
        $kernel = $this->container->get('http_kernel');

        $path = array(
            '_controller' => 'IsometriksSymEditBundle:Slider:index',
            'name' => $widget->getOption('slider'),
        );

        $subRequest = $request->duplicate(array(), null, $path);

        return $kernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST)->getContent();
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('slider', 'entity_property', array(
                'label' => 'Slider',
                'help_block' => 'Choose slider to display',
                'property_path' => 'options[slider]',
                'class' => 'IsometriksSymEditBundle:Slider',
                'property' => 'name',
                'property_value' => 'name',
            ));
    }

    public function getName()
    {
        return 'slider';
    }

    public function getDescription()
    {
        return 'Slider';
    }
}