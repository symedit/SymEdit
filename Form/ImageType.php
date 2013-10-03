<?php

namespace Isometriks\Bundle\SymEditBundle\Form; 

use Isometriks\Bundle\MediaBundle\Form\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends FileType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver); 
        
        $resolver->setDefaults(array(
            'data_class' => 'Isometriks\Bundle\SymEditBundle\Model\Image', 
            'require_name' => true, 
            'strategy' => 'input', 
            'required' => true,
            'translation_domain' => 'SymEdit', 
            'label' => 'Image',
        ));
    }

    public function getName()
    {
        return 'symedit_image';
    }
}
