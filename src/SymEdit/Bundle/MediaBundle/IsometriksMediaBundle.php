<?php

namespace Isometriks\Bundle\MediaBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Isometriks\Bundle\MediaBundle\DependencyInjection\Compiler\DoctrineMappingsPass;

class IsometriksMediaBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'Isometriks\Bundle\MediaBundle\Model',
        ));
    }
}
