<?php

namespace SymEdit\Bundle\ResourceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sylius\Bundle\ResourceBundle\DependencyInjection\SyliusResourceExtension;

class SymEditResourceExtension extends SyliusResourceExtension
{
    /**
     * Maps parameters to their equivalent path in their arrays
     *
     * @param ContainerBuilder $container
     * @param string $path
     * @param array $config
     */
    protected function remapParameters(ContainerBuilder $container, $path, array $config)
    {
        $prefix = rtrim($this->getAlias().'.'.$path, '.');

        foreach ($config as $key => $value) {
            $container->setParameter(sprintf('%s.%s', $prefix, $key), $value);
        }
    }

    /**
     * Remap class parameters.
     *
     * @param array            $classes
     * @param ContainerBuilder $container
     */
    protected function mapClassParameters(array $classes, ContainerBuilder $container)
    {
        foreach ($classes as $model => $serviceClasses) {
            foreach ($serviceClasses as $service => $class) {
                $container->setParameter(sprintf('symedit.%s.%s.class', $service === 'form' ? 'form.type' : $service, $model), $class);
            }
        }
    }
}