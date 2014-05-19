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

class TwigExceptionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // Get the exception class
        $controller = $container->getParameter('symedit.twig.controller.exception.class');

        // Change the definition to use our class
        $definition = $container->getDefinition('twig.controller.exception');
        $definition->setClass($controller);
    }
}
