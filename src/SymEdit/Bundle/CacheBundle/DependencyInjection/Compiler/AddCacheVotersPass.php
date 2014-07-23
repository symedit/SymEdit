<?php

namespace SymEdit\Bundle\CacheBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Adds all configured cache voters, taken from Symfony Security Bundle
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class AddCacheVotersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('symedit_cache.decision_manager')) {
            return;
        }

        $voters = new \SplPriorityQueue();
        foreach ($container->findTaggedServiceIds('symedit_cache.voter') as $id => $attributes) {
            $priority = isset($attributes[0]['priority']) ? $attributes[0]['priority'] : 0;
            $voters->insert(new Reference($id), $priority);
        }

        $voters = iterator_to_array($voters);
        ksort($voters);

        $container->getDefinition('symedit_cache.decision_manager')->replaceArgument(0, array_values($voters));
    }
}
