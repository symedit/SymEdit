<?php

namespace Isometriks\Bundle\SymEditBundle\Routing;

use Doctrine\Common\Annotations\Reader;
use Sensio\Bundle\FrameworkExtraBundle\Routing\AnnotatedRouteControllerLoader;
use Symfony\Component\Routing\RouteCollection;

/**
 * Loads Annotated routes so we can search for the PageController annotation
 */
class ControllerLoader extends AnnotatedRouteControllerLoader
{

    protected $pageControllerLoader;
    protected $controllerAnnotationClass = 'Isometriks\\Bundle\\SymEditBundle\\Annotation\\PageController';

    /**
     * Constructor.
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader, PageControllerLoader $pageControllerLoader)
    {
        parent::__construct($reader);

        $this->pageControllerLoader = $pageControllerLoader;
    }

    public function load($class, $type = null)
    {
        $collection = parent::load($class, $type);
        $class = new \ReflectionClass($class);

        if ($annot = $this->reader->getClassAnnotation($class, $this->controllerAnnotationClass)) {
            $pageControllerPath = $annot->getName();
            $defaultRouteName = $annot->getDefault();

            $this->pageControllerLoader->prepareCollection($collection, $pageControllerPath, $defaultRouteName);
        }

        return $collection;
    }

}