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
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;

class SubmenuStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        /**
         * Don't render without a current page
         */
        if ($page === null) {
            return false;
        }

        return $this->render('@SymEdit/Widget/submenu.html.twig', array(
            'page' => $page,
            'nav_class' => $widget->getOption('nav_class'),
            'level' => $widget->getOption('level'),
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('level', 'integer', array(
                'label' => 'Menu level',
                'help_block' => 'Level to display, cannot be greater than current page. Starts at 1',
                'constraints' => array(
                    new Range(array(
                        'min' => 1,
                        'minMessage' => 'Minimum level is 1',
                    )),
                ),
            ))
            ->add('nav_class', 'text', array(
                'label' => 'Navigation UL Class',
            ));
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'level' => 1,
            'nav_class' => 'nav nav-pills nav-stacked',
        ));
    }

    public function getName()
    {
        return 'submenu';
    }

    public function getDescription()
    {
        return 'Sub-Menu';
    }
}
