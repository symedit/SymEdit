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

use SymEdit\Bundle\BlogBundle\Form\Type\CategoryType as BaseCategoryType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends BaseCategoryType
{
    public function buildSeoForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('seo', 'symedit_seo')
        ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Build Basic Tab
        $basic = $builder->create('basic', 'tab', array(
            'label' => 'Basic',
            'inherit_data' => true,
            'icon' => 'info-sign',
        ));

        $this->buildBasicForm($basic, $options);

        // Build SEO Tab
        $seo = $builder->create('seo', 'tab', array(
            'label' => 'SEO',
            'inherit_data' => true,
            'icon' => 'search',
        ));

        $this->buildSeoForm($seo, $options);

        // Add tabs
        $builder
            ->add($basic)
            ->add($seo)
        ;
    }

    public function getName()
    {
        return 'symedit_category';
    }
}
