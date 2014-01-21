<?php

namespace SymEdit\Bundle\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileType extends AbstractType
{
    protected $mediaClass;

    public function __construct($mediaClass)
    {
        $this->mediaClass = $mediaClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new EventListener\FileTypeSubscriber($options));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->mediaClass,
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
