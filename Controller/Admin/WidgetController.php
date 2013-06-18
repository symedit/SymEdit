<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin; 

use Symfony\Component\HttpFoundation\Request; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template; 
use Isometriks\Bundle\SymEditBundle\Controller\Controller; 
use Isometriks\Bundle\SymEditBundle\Form\EventListener\WidgetSubscriber; 
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;

/**
 * @Route("/widget")
 */
class WidgetController extends Controller
{
    private $manager; 
    
    /**
     * @Route("/", name="admin_widget")
     * @Template()
     */
    public function indexAction()
    {
        $manager = $this->getManager(); 
        $areas = $manager->getWidgetAreas(); 
        
        return array(
            'areas' => $areas, 
        ); 
    }
    
    /**
     * @Route("/edit/{id}", name="admin_widget_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getManager(); 
        $widget = $manager->getWidgetBy(array('id' => $id)); 
        
        if($widget === null){
            throw new \Exception(sprintf('Could not find widget with name "%s".', $name)); 
        }
        
        $form = $this->getWidgetForm($widget); 
        
        return array(
            'entity' => $widget, 
            'form' => $form->createView(), 
        ); 
    }
    
    /**
     * @Route("/update/{id}", name="admin_widget_update")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getManager(); 
        $widget = $manager->getWidgetBy(array('id' => $id)); 
        
        if($widget === null){
            throw new \Exception(sprintf('Could not find widget with name "%s".', $name)); 
        }
        
        $form = $this->getWidgetForm($widget); 
        $form->bind($request); 
        
        if($form->isValid()){
            $manager->saveWidget($widget); 
            
            return $this->redirect($this->generateUrl('admin_widget')); 
        }
        
        return $this->render('@IsometriksSymEdit/Admin/Widget/edit.html.twig', array(
            'entity' => $widget, 
            'form' => $form->createView(), 
        )); 
    }
    
    /**
     * Get the form for the corresponding widget. 
     * 
     * @param \Isometriks\Bundle\SymEditBundle\Model\WidgetInterface $widget
     * @return \Symfony\Component\Form\FormInterface $form
     */
    private function getWidgetForm(WidgetInterface $widget)
    {
        $manager = $this->getManager(); 
        
        $builder = $this->createFormBuilder($widget, array(
            'data_class' => $manager->getWidgetClass(), 
        )); 
        
        $subscriber = new WidgetSubscriber($builder, $manager->getWidgetAreaClass()); 
        
        $builder->addEventSubscriber($subscriber); 
        
        return $widget->getStrategy()->getForm($builder);
    }
    
    /**
     * @return \Isometriks\Bundle\SymEditBundle\Widget\WidgetManager $manager
     */
    private function getManager()
    {
        if($this->manager === null){
            $this->manager = $manager = $this->get('isometriks_sym_edit.widget.manager');
        }
        
        return $this->manager; 
    }
}