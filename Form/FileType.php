<?php

namespace Isometriks\Bundle\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new EventListener\FileTypeSubscriber($options)); 
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'require_name' => true, 
            'strategy' => 'input', 
            'required' => true,
            'callback' => null, 
            'parent_update' => null, 
            'file_label' => 'File', 
            'file_help' => false, 
            'name_label' => 'File Name', 
            'name_help' => false, 
        ));
    }

    public function getName()
    {
        return 'isometriks_bundle_mediabundle_filetype';
    }

}
