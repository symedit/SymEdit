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
use Symfony\Component\OptionsResolver\OptionsResolver;

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
        // Left blank for tab builder
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'tabs_data' => [
                'basic' => [
                    'label' => 'Basic',
                    'icon' => 'info-circle',
                ],
                'seo' => [
                    'label' => 'SEO',
                    'icon' => 'search',
                ],
            ],
        ]);
    }

    public function getName()
    {
        return 'symedit_category';
    }
}
