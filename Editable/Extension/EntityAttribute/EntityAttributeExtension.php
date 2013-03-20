<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\EntityAttribute; 

use Isometriks\Bundle\SymEditBundle\Editable\AbstractEditableExtension;  
use Isometriks\Bundle\SymEditBundle\Editable\Editable; 
use Isometriks\Bundle\SymEditBundle\Editable\Extension\EntityAttribute\Form\EntityAttributeType; 
use Symfony\Component\Form\Form; 
use Symfony\Component\Form\FormFactory; 
use Symfony\Component\Security\Core\SecurityContext;

class EntityAttributeExtension extends AbstractEditableExtension
{
    public function supports(Editable $editable)
    {
        return strtolower($editable->getType()) === 'entityattribute'; 
    }

    public function execute(Editable $editable, FormFactory $factory, SecurityContext $context)
    {
        if($context->getToken() !== null && $context->isGranted('ROLE_ADMIN_EDITABLE')){
            
            $form = $factory->create(new EntityAttributeType(), array(
                'class' => get_class($editable->getSubject()), 
                'value' => $this->getValue($editable), 
                'attribute' => $editable->getParameter('attribute'), 
            ));
            
            return $this->renderView('IsometriksSymEditBundle:Editable/EntityAttribute:edit.html.twig', array(
                'form' => $form->createView(), 
                'id' => $editable->getSubject()->getId(), 
             ));
            
        } else {
            return $this->getValue($editable);
        }
    }
    
    /**
     * @TODO Probably use the Symfony property compoment here instead..
     * 
     * @param \Isometriks\Bundle\SymEditBundle\Editable\Editable $editable
     * @return type
     */
    private function getValue(Editable $editable)
    {
        $method = sprintf('get%s', ucfirst($editable->getParameter('attribute'))); 
        return $editable->getSubject()->$method();     
    }
    
    public function getJavascripts()
    {
        return array(
            'bundles/isometrikssymedit/js/editable/jquery.ajaxsubmit.js',
            'bundles/isometrikssymedit/redactor/redactor.min.js', 
        );
    }
    
    public function getStylesheets()
    {
        return array(
            'bundles/isometrikssymedit/redactor/redactor-inline.css', 
        );
    }
}