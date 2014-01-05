<?php

namespace SymEdit\Bundle\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SymEdit\Bundle\CoreBundle\Widget\WidgetRegistry; 

class WidgetStrategyType extends AbstractType 
{
    private $registry; 
    
    public function __construct(WidgetRegistry $registry)
    {
        $this->registry = $registry; 
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choices = array(); 
        
        foreach($this->registry->getStrategies() as $strategy){
            $choices[$strategy->getName()] = $strategy->getDescription(); 
        }

        $resolver->setDefaults(array(
            'choices' => $choices,
            'label' => 'Widget Strategy', 
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'symedit_widget_strategy';
    }

}