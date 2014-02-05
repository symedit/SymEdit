<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle;

use SymEdit\Bundle\StylizerBundle\DependencyInjection\Compiler\InjectorCompilerPass;
use SymEdit\Bundle\StylizerBundle\DependencyInjection\Compiler\LoaderCompilerPass;
use SymEdit\Bundle\StylizerBundle\DependencyInjection\SymEditStylizerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditStylizerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new InjectorCompilerPass());
        $container->addCompilerPass(new LoaderCompilerPass());
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
