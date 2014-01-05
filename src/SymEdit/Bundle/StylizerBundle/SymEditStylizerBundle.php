<?php

namespace SymEdit\Bundle\StylizerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymEdit\Bundle\StylizerBundle\DependencyInjection\Compiler\InjectorCompilerPass;

class SymEditStylizerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new InjectorCompilerPass());
    }

    public function getParent()
    {
        return 'AsseticBundle';
    }
}
