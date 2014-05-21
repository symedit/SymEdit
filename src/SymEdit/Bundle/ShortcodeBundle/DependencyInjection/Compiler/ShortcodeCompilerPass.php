<?php

namespace SymEdit\Bundle\ShortcodeBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ShortcodeCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $shortCodes = array();
        foreach ($container->findTaggedServiceIds('symedit_shortcode.shortcode') as $id => $attributes) {
            if (!isset($attributes[0]['alias'])) {
                throw new \Exception(sprintf('No alias for shortcode "%s"', $id));
            }

            $shortCodes[$attributes[0]['alias']] = new Reference($id);
        }

        $rendererDefinition = $container->getDefinition('symedit_shortcode.renderer');
        $rendererDefinition->replaceArgument(0, $shortCodes);
    }
}