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

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class SubmenuStrategy extends PageAwareAbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        /*
         * Don't render without a current page
         */
        if ($page === null) {
            return false;
        }

        return $this->render($widget, [
            'page' => $page,
            'nav_class' => $widget->getOption('nav_class'),
            'level' => $widget->getOption('level'),
        ]);
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('level', IntegerType::class, [
                'label' => 'Menu level',
                'help_block' => 'Level to display, cannot be greater than current page. Starts at 1',
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'minMessage' => 'Minimum level is 1',
                    ]),
                ],
            ])
            ->add('nav_class', TextType::class, [
                'label' => 'Navigation UL Class',
            ])
        ;
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'level' => 1,
            'nav_class' => 'nav nav-pills nav-stacked',
            'template' => '@SymEdit/Widget/submenu.html.twig',
        ]);
    }

    public function getName()
    {
        return 'submenu';
    }

    public function getDescription()
    {
        return 'core.submenu';
    }
}
