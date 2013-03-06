<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('name', 'text', array(
                'label' => 'Slug', 
                'help_block' => 'Lowercase, numbers, hyphens and underscores.',
            ))
            ->add('parent', 'entity', array(
                'empty_value' => '(Root Category)', 
                'class' => 'Isometriks\\Bundle\\SymEditBundle\\Entity\\Category', 
                'required' => false,
            ))
            ->add('seo', new SeoVirtualType())
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Isometriks\Bundle\SymEditBundle\Entity\Category'
        ));
    }

    public function getName()
    {
        return 'isometriks_bundle_symeditbundle_categorytype';
    }
}
