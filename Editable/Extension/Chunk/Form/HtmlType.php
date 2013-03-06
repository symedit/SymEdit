<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class HtmlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('html', 'textarea', array(
                'label_render' => false, 
                'property_path' => 'options[html]', 
                'attr' => array(
                    'class' => 'redactor', 
                    'data-update' => 'change', 
                )
            ))
        ;
    }

    public function getName()
    {
        return 'isometriks_bundle_symeditbundle_editable_chunk_htmltype';
    }
}
