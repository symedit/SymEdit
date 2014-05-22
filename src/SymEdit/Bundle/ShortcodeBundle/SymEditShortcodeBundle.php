<?php

namespace SymEdit\Bundle\ShortcodeBundle;

use SymEdit\Bundle\ShortcodeBundle\DependencyInjection\Compiler\ShortcodeCompilerPass;
use SymEdit\Bundle\ShortcodeBundle\DependencyInjection\SymEditShortcodeExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditShortcodeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ShortcodeCompilerPass());
    }

    public function getContainerExtension()
    {
        return new SymEditShortcodeExtension();
    }
}
