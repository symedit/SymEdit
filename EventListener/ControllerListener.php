<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpKernel\HttpKernel;

/**
 * This listener checks requests for controllers. If it finds the @PageController annotation, 
 * and finds a corresponding Page, then it will inject it into the controller for you. 
 */
class ControllerListener
{
    private $router;
    private $reader;
    private $doctrine;
    private $annotationClass = 'Isometriks\Bundle\SymEditBundle\Annotation\PageController';
    private $controllerClass = 'Isometriks\Bundle\SymEditBundle\Controller\PageController'; 

    public function __construct(Router $router, Reader $reader, Registry $doctrine)
    {
        $this->router = $router;
        $this->reader = $reader;
        $this->doctrine = $doctrine;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller) || $event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        $class = new \ReflectionClass($controller[0]);
        $request = $event->getRequest(); 
        $repo = $this->doctrine->getManager()->getRepository('IsometriksSymEditBundle:Page'); 
                
        /**
         * The page ID is in the attributes from routing
         */
        if($class->getName() === $this->controllerClass){
            
            if(!$request->attributes->has('id')){
                return; 
            }
            
            $page = $repo->find($request->attributes->get('id')); 
            
        } elseif ($annot = $this->reader->getClassAnnotation($class, $this->annotationClass)) {
            
            $page = $repo->findOneBy(array(
                'pageControllerPath' => $annot->getName(),
            ));
            
            if(!$page){
                return; 
            }
            
        /**
         * None of these cases, just return there is no page to add. 
         */
        } else {
            
            return; 
        }
        
        /**
         * Add the page we found to the Request
         */
        $request->attributes->add(array(
            '_page' => $page,
        ));        
    }
}