<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SymEditSeoExtension extends Extension
{
    /**
     * {@inheritdoc}
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
        $loader->load('analyzers.xml');

        // Load the seo preferences
        $this->loadPreferences($container, $config['models']);
    }

    protected function remapParameters(ContainerBuilder $container, array $params = [], $prefix = null)
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
        $parameterParts = [$this->getAlias()];

        if ($prefix !== null) {
            $parameterParts[] = $prefix;
        }

        $parameterParts[] = $key;
        $parameter = implode('.', $parameterParts);

        $container->setParameter($parameter, $value);
    }

    protected function loadPreferences(ContainerBuilder $container, array $models)
    {
        $preferences = [];

        foreach ($models as $model => $props) {
            $preferences[] = new Definition\SeoPreferenceDefinition($model, $props['title'], $props['description']);
        }

        // Add to calculator
        $preferenceDefinition = $container->getDefinition('symedit_seo.calculator.preference');
        $preferenceDefinition->replaceArgument(0, $preferences);

        // Add to listener
        $subjectListenerDefinition = $container->getDefinition('symedit_seo.event_listener.symedit_subject');
        $subjectListenerDefinition->addArgument($preferences);
    }

    public function getAlias()
    {
        return 'symedit_seo';
    }
}
