<?php

namespace SymEdit\Bundle\MenuBundle;

use SymEdit\Bundle\MenuBundle\DependencyInjection\Compiler\MenuBuilderCompilerPass;
use SymEdit\Bundle\MenuBundle\DependencyInjection\Compiler\MenuExtensionCompilerPass;
use SymEdit\Bundle\MenuBundle\DependencyInjection\SymEditMenuExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditMenuBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MenuBuilderCompilerPass());
        $container->addCompilerPass(new MenuExtensionCompilerPass());
    }

    public function getContainerExtension()
    {
        return new SymEditMenuExtension();
    }
}
