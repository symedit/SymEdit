<?php

namespace Isometriks\Bundle\SymEditBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Isometriks\Bundle\SymEditBundle\Form\DataTransformer\WidgetAssociationTransformer; 
use Isometriks\Bundle\SymEditBundle\Model\Widget; 

class WidgetType extends AbstractType
{    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new WidgetAssociationTransformer();
        
        $basic = $builder->create('basic', 'form', array(
            'virtual' => true, 
            'data_class' => $options['widget_class'], 
        ))
            ->add('title')
            ->add('name', 'text', array(
                'help_block' => 'Numbers, letters, underscores, or hyphens.', 
            ))
            ->add('area', 'entity', array(
                'property' => 'area', 
                'class' => $options['widget_area_class'], 
            ))
            ->add('visibility', 'choice', array(
                'label' => 'Visibility', 
                'choices' => array(
                    Widget::INCLUDE_ALL => 'Include on ALL Pages', 
                    Widget::INCLUDE_ONLY => 'Include ONLY on specified', 
                    Widget::EXCLUDE_ONLY => 'Exclude ONLY on specified', 
                ), 
            ))
            ->add(
                $builder->create('assoc', 'textarea', array(
                    'required' => false, 
                    'auto_initialize' => false, 
                    'attr' => array(
                        'rows' => 8, 
                    ),
                ))->addModelTransformer($transformer)
            );
        
        $builder->add($basic);
                        
        $config = $builder->create('config', 'form', array(
            'virtual' => true, 
            'data_class' => $options['widget_class'], 
        )); 
        
        /**
         * Build the config form from the strategy
         */
        $options['strategy']->buildForm($config); 
        
        /**
         * Add to the final form if config has children
         */
        if($config->count() > 0){
            $builder->add($config); 
        }
        
        return $builder->getForm(); 
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'strategy', 
            'widget_class', 
            'widget_area_class', 
        ));
    }
    
    public function getName()
    {
        return 'symedit_widget';
    }
}
