<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
