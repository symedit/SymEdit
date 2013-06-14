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

            /**
             *  If corresponding page doesn't exist, don't load these routes. 
             */
            if ($page === null) {
                
                return new RouteCollection(); 
                
            /**
             * Find the Index route
             */
            } else {
                
                /**
                 * No Default route specified, find a route matching '/'
                 */
                if($annot->getDefault() === null){
                   
                    $found = false; 
                    foreach($collection->all() as $route){
                        if($route->getPath() === '/'){
                            $collection->add($page->getRoute(), clone $route); 

                            $found = true; 
                            break; 
                        }
                    }
                    
                    if(!$found){
                        throw new \Exception('Could not determine the index route, you should provide one in the annotation through the "default" attribute');
                    }
                    
                /**
                 * Default route specified, find it or throw error
                 */
                } else {
                    
                    if($defaultRoute = $collection->get($annot->getDefault())){
                        $collection->add($page->getRoute(), clone $defaultRoute); 
                    } else {
                        throw new \Exception(sprintf('Default route "%s" does not exist', $annot->getDefault())); 
                    }  
                }
                
                $collection->addPrefix($page->getPath());
                $collection->addDefaults(array(
                    '_page_id' => $page->getId(), 
                )); 
            }
        }

        return $collection;
    }
}