<?php

namespace SymEdit\Bundle\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SymEdit\Bundle\MediaBundle\Form\EventListener\FileTypeSubscriber;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new FileTypeSubscriber($options));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'require_name' => true,
            'required' => true,
            'callback' => null,
            'file_label' => 'File',
            'file_help' => false,
            'name_label' => 'File Name',
            'name_help' => false,
        ));
    }

    public function getName()
    {
        return 'symedit_media';
    }
}
