<?php

namespace SymEdit\Bundle\MediaBundle;

use SymEdit\Bundle\MediaBundle\DependencyInjection\SymEditMediaExtension;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditMediaBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'SymEdit\Bundle\MediaBundle\Model',
        ));
    }

    public function getContainerExtension()
    {
        return new SymEditMediaExtension();
    }
}
