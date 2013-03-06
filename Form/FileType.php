<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new EventListener\FileTypeSubscriber($builder->getFormFactory(), $options)); 
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'require_name' => true, 
            'strategy' => 'input', 
            'required' => true,
            'callback' => null, 
            'parent_update' => null, 
        ));
    }

    public function getName()
    {
        return 'isometriks_bundle_symeditbundle_filetype';
    }

}
