<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\EntityAttribute\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntityAttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attribute', 'hidden')
            ->add('class', 'hidden')
            ->add('value', 'textarea', array(
                'attr' => array(
                    'class' => 'redactor', 
                    'data-update' => 'change', 
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(

        ));
    }

    public function getName()
    {
        return 'symedit_editable_entityattributetype';
    }
}
