<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SelectImageType extends AbstractType {

    private $slug;

    public function __construct($slug = null)
    {
        $this->slug = $slug;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('new_image', new ImageType(($this->slug!==null?$this->slug:'blog-temp')), array(
                'required' => false,
                'property_path' => false, 
                'widget_control_group' => false, 
                'label' => 'Upload New', 
            ))
            ->add('existing_image', 'entity', array(
                'class' => 'Isometriks\\Bundle\\SymEditBundle\\Entity\\Image',
                'label' => 'Select Existing', 
                'property_path' => false, 
                'required' => false, 
                'empty_value' => ' - None - ', 
            ));
        
        $builder->addEventSubscriber(new EventListener\SelectImageSubscriber($builder->getFormFactory()));  
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'virtual' => true, 
        ));
    }

    public function getName()
    {
        return 'isometriks_bundle_symeditbundle_selectimagetype';
    }

}
