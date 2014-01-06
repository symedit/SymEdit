<?php

namespace SymEdit\Bundle\WidgetBundle;

use SymEdit\Bundle\WidgetBundle\DependencyInjection\Compiler\WidgetStrategyCompilerPass;
use SymEdit\Bundle\WidgetBundle\DependencyInjection\SymEditWidgetExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditWidgetBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new WidgetStrategyCompilerPass());
    }

    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        return new SymEditWidgetExtension();
    }
}
