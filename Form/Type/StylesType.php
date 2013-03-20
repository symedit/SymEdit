<?php

namespace Isometriks\Bundle\StylizerBundle\Form\Type; 

use Symfony\Component\Form\AbstractType; 
use Symfony\Component\Form\FormBuilderInterface; 
use Isometriks\Bundle\StylizerBundle\Model\Stylizer; 

class StylesType extends AbstractType
{
    protected $stylizer; 
    
    public function __construct(Stylizer $stylizer)
    {
        $this->stylizer = $stylizer; 
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $config = $this->stylizer->getConfigData()->getVariableConfig(); 
        
        foreach($config as $name => $data){
            
            $label = isset($data['label']) ? $data['label'] : '';
            $options = isset($data['options']) ? $data['options'] : array(); 
            
            $builder->add($name, 'text', array_merge(
                array(
                    'label' => $label, 
                    'property_path' => sprintf('[%s]', $name), 
                ), 
                $options
            )); 
        }
    }
    
    public function getName()
    {
        return 'styles'; 
    }    
}