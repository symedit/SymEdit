<?php

namespace Isometriks\Bundle\UserBundle; 

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Isometriks\Bundle\SymEditBundle\DependencyInjection\Compiler\DoctrineMappingsPass;

class IsometriksUserBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'Isometriks\Bundle\UserBundle\Model',
        ));        
    }
    
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}