<?php

namespace Isometriks\Bundle\SettingsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface; 
use Isometriks\Bundle\SettingsBundle\Model\Settings; 
use Symfony\Component\Security\Core\SecurityContext; 

class SettingsType extends AbstractType
{
    private $settings;
    private $context; 
    
    public function __construct(Settings $settings, SecurityContext $context)
    {
        $this->settings = $settings;
        $this->context = $context; 
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groups = $builder->create('groups', 'form', array(
            'virtual' => true, 
        )); 
        
        $config = $this->settings->getConfigData(); 
        
        foreach($config->getGroups() as $group){
            
            if($role = $group->getRole()){
                if(!$this->context->isGranted($role)){
                    continue; 
                }
            }
            
            $groupForm = $builder->create($group->getName(), 'form', array(
                'virtual' => true, 
                'label' => $group->getLabel(), 
            ));   
            
            foreach($group->getSettings() as $setting){
                $groupForm->add($setting->getName(), $setting->getType(), array_replace_recursive(
                    $group->getDefaultOptions(), 
                    array(
                        'property_path' => sprintf('[%s][%s]', $group->getName(), $setting->getName()), 
                    // TODO Constraints
                    ), 
                    $setting->getOptions()
                ));
            }
            
            $groups->add($groupForm); 
        }
        
        $builder->add($groups);  
    }
    
    public function parseNodes(array $nodes)
    {
        $values = array();

        foreach ($nodes as $name => $childNodes) {
            if (is_numeric($name) && is_array($childNodes) && count($childNodes) == 1) {
                $options = current($childNodes);

                if (is_array($options)) {
                    $options = $this->parseNodes($options);
                }

                $values[] = $this->newConstraint(key($childNodes), $options);
            } else {
                if (is_array($childNodes)) {
                    $childNodes = $this->parseNodes($childNodes);
                }

                $values[$name] = $childNodes;
            }
        }

        return $values;
    }
    
    private function newConstraint($name, $options)
    {
        if (strpos($name, '\\') !== false && class_exists($name)) {
            $className = (string) $name;
        } elseif (strpos($name, ':') !== false) {
            list($prefix, $className) = explode(':', $name, 2);

            if (!isset($this->namespaces[$prefix])) {
                throw new MappingException(sprintf('Undefined namespace prefix "%s"', $prefix));
            }

            $className = $this->namespaces[$prefix].$className;
        } else {
            $className = 'Symfony\\Component\\Validator\\Constraints\\'.$name;
        }

        return new $className($options);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'virtual' => true, 
        )); 
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'settings';
    }
}