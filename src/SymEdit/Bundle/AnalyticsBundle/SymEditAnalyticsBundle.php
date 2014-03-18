<?php

namespace SymEdit\Bundle\AnalyticsBundle;

use SymEdit\Bundle\AnalyticsBundle\DependencyInjection\Compiler\ReportCompilerPass;
use SymEdit\Bundle\AnalyticsBundle\DependencyInjection\SymEditAnalyticsExtension;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\Compiler\DoctrineMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditAnalyticsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ReportCompilerPass());

        /**
         * Add Doctrine Mappings
         */
        DoctrineMappingsPass::addMappings($container, array(
            realpath(__DIR__.'/Resources/config/doctrine/model') => 'SymEdit\Bundle\AnalyticsBundle\Model',
        ));
    }

    public function getContainerExtension()
    {
        return new SymEditAnalyticsExtension();
    }
}
