<?php

namespace SymEdit\Bundle\MenuBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MenuExtensionCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $extensions = new \SplPriorityQueue();

        foreach ($container->findTaggedServiceIds('symedit_menu.menu_extension') as $id => $tag) {
            $priority = isset($tag[0]['priority']) ? $tag[0]['priority'] : 0;

            $extensions->insert(new Reference($id), $priority);
        }

        $sortedExtensions = iterator_to_array($extensions);

        $menuProviderDefinition = $container->getDefinition('symedit_menu.provider.symedit');
        $menuProviderDefinition->replaceArgument(2, $sortedExtensions);
    }
}
