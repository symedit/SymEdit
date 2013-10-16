<?php

namespace Isometriks\Bundle\SymEditBundle\Form; 

use Isometriks\Bundle\MediaBundle\Form\FileType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class ImageType extends FileType
{
    protected $mediaClass;
    
    public function __construct($mediaClass)
    {
        $this->mediaClass = $mediaClass;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver); 
        
        $resolver->setDefaults(array(
            'data_class' => $this->mediaClass, 
            'require_name' => true, 
            'required' => true,
            'translation_domain' => 'SymEdit', 
            'label' => 'Image',
            'show_image' => true,
        ));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['show_image'] = $options['show_image'];
    }

    public function getName()
    {
        return 'symedit_image';
    }
}
