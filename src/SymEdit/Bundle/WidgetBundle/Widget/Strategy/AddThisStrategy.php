<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddThisStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget)
    {
        return $this->render('@SymEdit/Widget/addthis.html.twig', array(
            'include_script' => $widget->getOption('include_script'),
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('include_script', 'checkbox', array(
                'required' => false,
                'label' => 'Include Javascript File?',
                'help_block' => 'Try not to include the Javascript file twice on any page.',
            ));
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'include_script' => true,
        ));
    }

    public function getName()
    {
        return 'addthis';
    }

    public function getDescription()
    {
        return 'widget.addthis';
    }
}
