<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
