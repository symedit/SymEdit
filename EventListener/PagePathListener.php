<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Isometriks\Bundle\SymEditBundle\Entity\Page; 
use Symfony\Bundle\FrameworkBundle\Routing\Router; 

/**
 * This listener deletes the routing cache when a Page has been updated.  
 */
class PagePathListener
{
    private $router; 
    
    public function __construct(Router $router)
    {
        $this->router = $router;     
    }
    
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->updateRoutes($args); 
    }
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->updateRoutes($args); 
    }
    
    public function updateRoutes(LifecycleEventArgs $args)
    {
        $entity  = $args->getEntity();
        
        // In case the page parent has changed, or its path has changed
        if($entity instanceof Page){
            $matcher_class   = $this->router->getOption('matcher_cache_class'); 
            $generator_class = $this->router->getOption('generator_cache_class'); 
            $cache_dir       = $this->router->getOption('cache_dir'); 
            
            $matcher_file   = sprintf('%s/%s.php', $cache_dir, $matcher_class); 
            $generator_file = sprintf('%s/%s.php', $cache_dir, $generator_class); 
            
            if(file_exists($matcher_file)){
                unlink($matcher_file); 
            }
            
            if(file_exists($generator_file)){
                unlink($generator_file); 
            }
        }
    }
}