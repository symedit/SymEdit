<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AnnotationLoaderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('sensio_framework_extra.routing.loader.annot_class');
        $definition->setClass('%symedit.routing.loader.controller.class%');
        $definition->addArgument($container->getDefinition('symedit.routing.loader.page_controller'));

        $yamlLoaderDefinition = $container->getDefinition('routing.loader.yml');
        $yamlLoaderDefinition->setClass('%symedit.routing.loader.yaml.class%');
        $yamlLoaderDefinition->addArgument($container->getDefinition('symedit.routing.loader.page_controller'));
    }
}
