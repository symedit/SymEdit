<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends FileType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver); 
        
        $resolver->setDefaults(array(
            'data_class' => 'Isometriks\\Bundle\\SymEditBundle\\Entity\\Image', 
            'require_name' => true, 
            'strategy' => 'input', 
            'required' => true,
            'translation_domain' => 'SymEdit', 
        ));
    }

    public function getName()
    {
        return 'isometriks_bundle_symeditbundle_imagetype';
    }

}
