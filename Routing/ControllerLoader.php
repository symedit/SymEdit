<?php

namespace Isometriks\Bundle\SymEditBundle\Routing;

use Doctrine\Common\Annotations\Reader;
use Sensio\Bundle\FrameworkExtraBundle\Routing\AnnotatedRouteControllerLoader;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Routing\RouteCollection;

class ControllerLoader extends AnnotatedRouteControllerLoader
{
    protected $doctrine;
    protected $controllerAnnotationClass = 'Isometriks\\Bundle\\SymEditBundle\\Annotation\\PageController';

    /**
     * Constructor.
     *
     * @param Reader $reader
     * @param Registry $doctrine
     */
    public function __construct(Reader $reader, Registry $doctrine)
    {
        $this->reader = $reader;
        $this->doctrine = $doctrine;
    }

    public function load($class, $type = null)
    {
        $collection = parent::load($class, $type);

        $class = new \ReflectionClass($class);
        if ($annot = $this->reader->getClassAnnotation($class, $this->controllerAnnotationClass)) {
            $path = $annot->getName();

            $em = $this->doctrine->getManager();
            $page = $em->getRepository('IsometriksSymEditBundle:Page')->findOneBy(array(
                'pageController' => true,
                'pageControllerPath' => $path
            ));

            // If corresponding page doesn't exist, don't load these routes. 
            if ($page === null) {
                $collection = new RouteCollection();
            } else {
                $collection->addPrefix($page->getPath());
            }
        }

        return $collection;
    }
}