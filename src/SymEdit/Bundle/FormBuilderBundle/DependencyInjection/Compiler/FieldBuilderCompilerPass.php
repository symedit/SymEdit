<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FieldBuilderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $mapping = [];

        foreach ($container->findTaggedServiceIds('symedit_form_builder.builder') as $id => $tags) {
            $service = new Reference($id);

            foreach ($tags as $tag) {
                if (!isset($tag['type'])) {
                    throw new \Exception('symedit_form_builder.builder tags require a "type"');
                }

                $mapping[$tag['type']] = $service;
            }
        }

        $registryDefinition = $container->getDefinition('symedit_form_builder.builder_registry');
        $registryDefinition->replaceArgument(1, $mapping);
    }
}
