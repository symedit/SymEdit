<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MenuBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Build an array of menus into form:.
 *
 * array(
 *     'menu_name' => array(
 *         'service.builder1',
 *         'service.builder2',
 *     ),
 *     'another_name' => ...
 * )
 */
class MenuBuilderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $menus = [];

        foreach ($container->findTaggedServiceIds('symedit_menu.builder') as $id => $tag) {
            if (!isset($tag[0]['menu'])) {
                throw new ParameterNotFoundException('Please supply a "menu" name in your tag');
            }

            $menu = $tag[0]['menu'];
            $priority = isset($tag[0]['priority']) ? $tag[0]['priority'] : 0;

            if (!isset($menus[$menu])) {
                $menus[$menu] = new \SplPriorityQueue();
            }

            $menus[$menu]->insert(new Reference($id), $priority);
        }

        // Get sorted menus
        $sortedMenus = [];

        foreach ($menus as $menu => $builders) {
            $sortedMenus[$menu] = iterator_to_array($builders);
        }

        $menuProviderDefinition = $container->getDefinition('symedit_menu.provider.symedit');
        $menuProviderDefinition->replaceArgument(1, $sortedMenus);
    }
}
