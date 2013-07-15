<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin; 

use Symfony\Component\HttpFoundation\Request; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template; 
use Isometriks\Bundle\SymEditBundle\Controller\Controller; 
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
     * @Route("/new/{strategyName}", name="admin_widget_new")
     * @Template()
     */
    public function newAction($strategyName = null)
    {
        if($strategyName === null){
            
            /* @var $registry \Isometriks\Bundle\SymEditBundle\Widget\WidgetRegistry */
            $registry = $this->get('isometriks_symedit.widget.registry'); 
            $strategies = $registry->getStrategies(); 
            
            return $this->render('@IsometriksSymEdit/Admin/Widget/choose.html.twig', array(
                'strategies' => $strategies, 
            )); 
            
        } else {
            
            $widget = $this->createWidget($strategyName); 
            $form = $this->getWidgetForm($widget); 
            
            return array(
                'entity' => $widget, 
                'form' => $form->createView(), 
            );
        }
    }
    
    /**
     * @Route("/create/{strategyName}", name="admin_widget_create")
     * @Template("@IsometriksSymEdit/Admin/Widget/new.html.twig")
     */
    public function createAction(Request $request, $strategyName)
    {
        $widget = $this->createWidget($strategyName); 
        $form = $this->getWidgetForm($widget); 
        
        $form->bind($request); 
        
        if($form->isValid()){
            $this->getManager()->saveWidget($widget); 
            $this->addFlash('notice', 'Widget created successfully.'); 
            
            return $this->redirect($this->generateUrl('admin_widget')); 
        }
        
        $this->addFlash('error', 'Error Creating Widget.'); 
        
        return array(
            'entity' => $widget, 
            'form' => $form->createView(), 
        ); 
    }
    
    /**
     * @Route("/{id}/edit", name="admin_widget_edit")
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
     * @Route("/{id}/update", name="admin_widget_update")
     * @Template("@IsometriksSymEdit/Admin/Widget/edit.html.twig")
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
            
            $this->addFlash('notice', 'Widget Updated.'); 
            
            return $this->redirect($this->generateUrl('admin_widget')); 
        }
        
        $this->addFlash('error', 'Error Updating Widget'); 
        
        return array(
            'entity' => $widget, 
            'form' => $form->createView(), 
        ); 
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
        
        /**
         * @TODO: We should move the widget class / widget area classes
         *        to the service definition and inject into constructor. 
         */
        $form = $this->createForm('symedit_widget', $widget, array(
            'strategy' => $widget->getStrategy(), 
            'widget_class' => $manager->getWidgetClass(), 
            'widget_area_class' => $manager->getWidgetAreaClass(), 
        )); 

        return $form; 
    }
    
    /**
     * @return \Isometriks\Bundle\SymEditBundle\Widget\WidgetManager $manager
     */
    private function getManager()
    {
        if($this->manager === null){
            $this->manager = $manager = $this->get('isometriks_symedit.widget.manager');
        }
        
        return $this->manager; 
    }
    
    
    /**
     * @param string $strategyName
     * @return WidgetInterface
     */
    private function createWidget($strategyName)
    {
        /**
         * Try to create a new widget, you can type these in the address
         * bar so don't let Symfony crash, just throw a 404. 
         */
        try {
            $widget = $this->getManager()->createWidget($strategyName); 
        } catch(\Excetion $e) {
            throw $this->createNotFoundException(sprintf('Widget with strategy name "%s" does not exist', $strategyName)); 
        }       
        
        return $widget; 
    }
}