<?php

namespace SymEdit\Bundle\StylizerBundle;

use SymEdit\Bundle\StylizerBundle\DependencyInjection\Compiler\InjectorCompilerPass;
use SymEdit\Bundle\StylizerBundle\DependencyInjection\SymEditStylizerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditStylizerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new InjectorCompilerPass());
    }

    public function getContainerExtension()
    {
        return new SymEditStylizerExtension();
    }

    public function getParent()
    {
        return 'AsseticBundle';
    }
}
