<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\EntityAttribute; 

use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Isometriks\Bundle\SymEditBundle\Editable\Extension\EntityAttribute\Form\EntityAttributeType; 
use Isometriks\Bundle\SymEditBundle\Model\UpdatableInterface; 
use Symfony\Bundle\FrameworkBundle\Controller\Controller; 

/**
 * @Route("/entityattribute")
 */
class EntityAttributeController extends Controller
{
    /**
     * @Route("/{id}/{attribute}/display", name="editable_entityattribute")
     */
    public function displayAction(Request $request, $id, $attribute)
    {
        $class   = $request->query->get('class'); 
        $entity  = $this->getEntity($id, $class); 
        $context = $this->get('security.context'); 
        $method  = 'get'.ucfirst($attribute);
        $value   = $entity->$method(); 
        
        if($context->isGranted('ROLE_ADMIN_EDITABLE')){  
            return $this->editAction($entity, $value, $attribute, $class); 
        } else {
            return $this->showAction($value);  
        }
    }
    
    public function showAction($value)
    {
        return new Response($value);  
    }
    

    /**
     * @Template()
     * @param type $value
     * @param type $attribute
     * @return type
     */
    public function editAction($entity, $value, $attribute, $class)
    {
        $data = array(
            'value' => $value, 
            'attribute' => $attribute,  
            'class' => $class, 
        ); 
            
        $form = $this->createForm(new EntityAttributeType(), $data);  
        
        return $this->render('IsometriksSymEditBundle:Editable/PageAttribute:edit.html.twig', array(
            'form' => $form->createView(), 
            'id'   => $entity->getId(),
        )); 
    }
    
    /**
     * @Route("/{id}/update", requirements={"id"="\d+"}, name="editable_entityattribute_update")
     */
    public function updateAction($id, Request $request)
    {
        $status = false; 
        $form = $this->createForm(new EntityAttributeType()); 
        $form->bind($request); 
        
        if($form->isValid()){
            $status = true; 
            $data = $form->getData(); 
            $entity = $this->getEntity($id, $data['class']); 
            
            /**
             * TODO: Use the propertypath stuff from Symfony. 
             */
            $method = sprintf('set%s', ucfirst($data['attribute'])); 

            if(!method_exists($entity, $method)){
                throw new \InvalidArgumentException(sprintf('Page attribute %s not editable. Please implement "%s"', $data['attribute'], $method)); 
            }

            $entity->$method($data['value']);

            $em = $this->getDoctrine()->getManager(); 
            $em->persist($entity); 
            $em->flush(); 
        }
        
        return new Response(json_encode(array(
            'status' => $status, 
        )));
    }
    
    private function getEntity($id, $class)
    {
        $em      = $this->getDoctrine()->getManager(); 
        $entity  = $em->getRepository($class)->find($id);
        
        return $entity; 
    }
}