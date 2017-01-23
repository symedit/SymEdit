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
use Symfony\Component\DependencyInjection\Reference;

class ExpressionLanguageCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->has('sylius.expression_language')) {
            $container->removeDefinition('sylius.expression_language');
        }

        // Setup alias for sylius
        $container->setAlias('sylius.expression_language', 'symedit.expression_language');

        // Get DI providers
        $definition = $container->getDefinition('symedit.expression_language');

        foreach ($container->findTaggedServiceIds('symedit.expression_language_provider') as $id => $tags) {
            $definition->addMethodCall('registerProvider', [new Reference($id)]);
        }

        // Add Settings Expression Parser to JsonLd Expression Engine
        if (!$container->hasDefinition('isometriks_json_ld_dumper.expression_language')) {
            return;
        }

        $jsonLdExpressionDefinition = $container->getDefinition('isometriks_json_ld_dumper.expression_language');
        $jsonLdExpressionDefinition->addMethodCall('registerProvider', [new Reference('symedit.expression_language.settings_provider')]);
    }
}
