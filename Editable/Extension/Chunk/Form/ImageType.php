<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', 'file', array(
                'attr' => array(
                    'class' => 'hidden', 
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
        return 'isometriks_bundle_symeditbundle_editable_chunk_imagetype';
    }
}
