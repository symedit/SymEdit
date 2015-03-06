<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use SymEdit\Bundle\WidgetBundle\Form\Type\WidgetType as BaseWidgetType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WidgetType extends BaseWidgetType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Left blank for tab builder
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'tabs_data' => array(
                'basic' => array(
                    'label' => 'symedit.form.widget.tab.basic',
                    'icon' => 'info-sign',
                    'data_class' => $this->widgetClass,
                ),
                'options' => array(
                    'label' => 'symedit.form.widget.tab.options',
                    'icon' => 'cog',
                    'inherit_data' => false,
                    'force_tab' => true,
                ),
            ),
        ));
    }
}
