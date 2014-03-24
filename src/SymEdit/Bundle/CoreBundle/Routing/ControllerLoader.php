<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Routing;

use Doctrine\Common\Annotations\Reader;
use Sensio\Bundle\FrameworkExtraBundle\Routing\AnnotatedRouteControllerLoader;
use Symfony\Component\Routing\RouteCollection;

/**
 * Loads Annotated routes so we can search for the PageController annotation
 */
class ControllerLoader extends AnnotatedRouteControllerLoader
{
    protected $pageControllerLoader;
    protected $controllerAnnotationClass = 'SymEdit\\Bundle\\CoreBundle\\Annotation\\PageController';

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

            $collection = $this->pageControllerLoader->prepareCollection($collection, $pageControllerPath, $defaultRouteName);
        }

        return $collection;
    }
}