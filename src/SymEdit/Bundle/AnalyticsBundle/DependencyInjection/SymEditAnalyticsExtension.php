<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\DependencyInjection;

use Sylius\Component\Resource\ResourceActions;
use SymEdit\Bundle\AnalyticsBundle\EventListener\SyliusTrackerListener;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class SymEditAnalyticsExtension extends SymEditResourceExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        // Load Resources
        $this->registerResources('symedit', $config['driver'], $config['resources'], $container);

        // Load Config Files
        $configFiles = [
            'services.xml', 'report.xml',
        ];

        foreach ($configFiles as $configFile) {
            $loader->load($configFile);
        }

        // Set Tracker Models
        $container->setParameter('symedit_analytics.tracker.models', $config['tracker']);

        // Create model events
        $this->createModelEvents($config['tracker'], $container);
    }

    private function createModelEvents(array $models, ContainerBuilder $container)
    {
        $definitions = [];

        foreach ($models as $modelName => $class) {
            $definitions[] = $this->createDefinition($modelName);
        }

        $container->addDefinitions($definitions);
    }

    /**
     * @param type $modelName
     * @return Definition
     */
    private function createDefinition($modelName)
    {
        $definition = new Definition(SyliusTrackerListener::class);
        $definition->addArgument(new Reference('symedit_analytics.tracker'));
        $definition->addTag('kernel.event_listener', [
            'event' => sprintf('symedit.%s.%s', $modelName, ResourceActions::SHOW),
            'method' => 'track',
        ]);

        return $definition;
    }

    public function getAlias()
    {
        return 'symedit_analytics';
    }
}
