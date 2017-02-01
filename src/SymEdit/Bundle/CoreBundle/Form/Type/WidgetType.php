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
use Symfony\Component\OptionsResolver\OptionsResolver;

class WidgetType extends BaseWidgetType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Left blank for tab builder
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'tabs_data' => [
                'basic' => [
                    'label' => 'symedit.form.widget.tab.basic',
                    'icon' => 'info-circle',
                ],
                'options' => [
                    'label' => 'symedit.form.widget.tab.options',
                    'icon' => 'cog',
                    'inherit_data' => false,
                    'force_tab' => true,
                ],
            ],
        ]);
    }
}
