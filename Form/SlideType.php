<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Isometriks\Bundle\SymEditBundle\Entity\Image; 

class SlideType extends AbstractType
{
    public function __construct(Image $image=null)
    {
        $this->image = $image; 
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('caption', 'textarea', array(
                'required' => false, 
                'attr' => array(
                    'class' => 'span4', 
                    'rows' => 5, 
                )
            ))
            ->add('position', 'choice', array(
                'required' => false, 
                'choices' => array(
                    '' => 'Bottom', 
                    'left' => 'Left', 
                    'top' => 'Top', 
                    'right' => 'Right',
                )
            ))
            ->add('image', new ImageType(), array(
                'widget_control_group' => false, 
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Isometriks\Bundle\SymEditBundle\Entity\Slide'
        ));
    }

    public function getName()
    {
        return 'isometriks_bundle_symeditbundle_slidetype';
    }
}
