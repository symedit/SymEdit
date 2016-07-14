<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GetSeoCalculators implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('symedit_seo.seo_manager')) {
            return;
        }

        $managerDefinition = $container->getDefinition('symedit_seo.seo_manager');
        $taggedServices = $container->findTaggedServiceIds('seo.calculator');

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $args = [new Reference($id)];

                if (isset($attributes['priority'])) {
                    $args[] = $attributes['priority'];
                }

                $managerDefinition->addMethodCall(
                    'addCalculator',
                    $args
                );
            }
        }
    }
}
