<?php

namespace SymEdit\Bundle\SeoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SymEditSeoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->remapParameters($container, $config);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('calculators.xml');
        $loader->load('form.xml');

        if ($config['annotations']) {
            $loader->load('annotations.xml');
        }
    }

    protected function remapParameters(ContainerBuilder $container, array $params = array(), $prefix = null)
    {
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $this->remapParameters($container, $value, $prefix === null ? $key : $prefix.'.'.$key);
            } else {
                $this->remapParameter($container, $key, $value, $prefix);
            }
        }
    }

    protected function remapParameter(ContainerBuilder $container, $key, $value, $prefix = null)
    {
        $parameterParts = array($this->getAlias());

        if ($prefix !== null) {
            $parameterParts[] = $prefix;
        }

        $parameterParts[] = $key;
        $parameter = implode('.', $parameterParts);

        $container->setParameter($parameter, $value);
    }

    public function getAlias()
    {
        return 'symedit_seo';
    }
}
