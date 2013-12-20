<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $basic = $builder->create('basic', 'tab', array(
            'label' => 'Basic',
            'inherit_data' => true,
        ));

        $basic
            ->add('title')
            ->add('name', 'text', array(
                'label' => 'Slug',
                'help_block' => 'Lowercase, numbers, hyphens and underscores.',
            ))
            ->add('parent', 'entity', array(
                'empty_value' => '(Root Category)',
                'class' => 'Isometriks\Bundle\SymEditBundle\Model\Category',
                'required' => false,
            ));


        $seo = $builder->create('seo', 'tab', array(
            'label' => 'SEO',
            'inherit_data' => true,
        ));

        $seo
            ->add('seo', new SeoVirtualType());


        $builder
            ->add($basic)
            ->add($seo);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'SymEdit',
        ));
    }

    public function getName()
    {
        return 'isometriks_symedit_category';
    }
}
