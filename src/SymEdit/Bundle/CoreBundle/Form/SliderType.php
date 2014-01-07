<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SliderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'admin.slider.name.label',
                'help_block' => 'admin.slider.name.help',
            ))
            ->add('description', 'textarea', array(
                'label' => 'admin.slider.description.label',
            ))
        ;
    }

    public function getName()
    {
        return 'symedit_slider';
    }
}
