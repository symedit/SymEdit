<?php

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class SliderStrategy extends AbstractWidgetStrategy
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        $request = $this->container->get('request');
        $kernel = $this->container->get('http_kernel');

        $path = array(
            '_controller' => 'SymEditBundle:Slider:index',
            'name' => $widget->getOption('slider'),
            'thumbnails' => $widget->getOption('thumbnails'),
        );

        $subRequest = $request->duplicate(array(), null, $path);

        return $kernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST)->getContent();
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'thumbnails' => false,
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('slider', 'entity_property', array(
                'label' => 'Slider',
                'help_block' => 'Choose slider to display',
                'class' => 'SymEdit\Bundle\CoreBundle\Model\Slider',
                'property' => 'name',
                'property_value' => 'name',
            ))
            ->add('thumbnails', 'checkbox', array(
                'label' => 'Show Thumbnails',
                'required' => false,
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
