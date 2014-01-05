<?php

namespace SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AnnotationLoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('sensio_framework_extra.routing.loader.annot_class');
        $definition->setClass('%isometriks_symedit.routing.loader.controller.class%');
        $definition->addArgument($container->getDefinition('isometriks_symedit.routing.loader.page_controller'));

        $yamlLoaderDefinition = $container->getDefinition('routing.loader.yml');
        $yamlLoaderDefinition->setClass('%isometriks_symedit.routing.loader.yaml.class%');
        $yamlLoaderDefinition->addArgument($container->getDefinition('isometriks_symedit.routing.loader.page_controller'));
    }
}