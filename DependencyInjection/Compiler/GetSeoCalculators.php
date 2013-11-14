<?php

namespace Isometriks\Bundle\SeoBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class GetSeoCalculators implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('isometriks_seo.seo_manager')) {
            return;
        }
        
        $managerDefinition = $container->getDefinition('isometriks_seo.seo_manager');
        $taggedServices = $container->findTaggedServiceIds('seo.calculator');
        
        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                
                $args = array(new Reference($id));
                
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