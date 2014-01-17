<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;

class SliderStrategy extends AbstractWidgetStrategy
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        $slider = $this->repository->findOneByName($widget->getOption('slider'));

        return $this->render('@SymEdit/Widget/slider.html.twig', array(
            'slider' => $slider,
            'thumbnails' => $widget->getOption('thumbnails'),
            'stretch' => $widget->getOption('stretch'),
        ));
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'thumbnails' => false,
            'stretch' => false,
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
            ))
            ->add('stretch', 'checkbox', array(
                'label' => 'Stretch',
                'required' => false,
            ))
        ;
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
