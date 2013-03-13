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
    private $annotationClass = 'Isometriks\\Bundle\\SymEditBundle\\Annotation\\PageController';

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

        if ($annot = $this->reader->getClassAnnotation($class, $this->annotationClass)) {
            $em = $this->doctrine->getManager();
            $page = $em->getRepository('IsometriksSymEditBundle:Page')->findOneBy(array(
                'pageControllerPath' => $annot->getName()
            ));

            // TODO: Hmm... this is kind of a problem..
            // This is preemptive, the controller might want to return
            // a cached response but this will slow it down a lot. 
            $page->setActive(true, true);

            $event->getRequest()->attributes->add(array(
                '_page' => $page
            ));
        }
    }
}