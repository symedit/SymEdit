<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $basic = $builder->create('basic', 'tab', array(
            'label' => 'Basic',
            'inherit_data' => true,
            'icon' => 'info-sign',
        ));

        $basic
            ->add('title')
            ->add('name', 'text', array(
                'label' => 'Slug',
                'help_block' => 'Lowercase, numbers, hyphens and underscores.',
            ))
            ->add('parent', 'entity', array(
                'empty_value' => '(Root Category)',
                'class' => 'SymEdit\Bundle\BlogBundle\Model\Category',
                'required' => false,
            ));

        $seo = $builder->create('seo', 'tab', array(
            'label' => 'SEO',
            'inherit_data' => true,
            'icon' => 'search',
        ));

        $seo
            ->add('seo', 'symedit_seo');

        $builder
            ->add($basic)
            ->add($seo);
    }

    public function getName()
    {
        return 'symedit_category';
    }
}
