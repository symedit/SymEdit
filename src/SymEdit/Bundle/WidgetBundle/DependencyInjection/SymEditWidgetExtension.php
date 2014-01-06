<?php

namespace SymEdit\Bundle\WidgetBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use SymEdit\Bundle\CoreBundle\DependencyInjection\SymEditResourceExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SymEditWidgetExtension extends SymEditResourceExtension
{
    protected $configFiles = array(
        'services', 'widget',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configDir = __DIR__.'/../Resources/config';

        list($config) = $this->configure($config, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS);

        $container->setParameter('symedit_widget.model_manager_name', $config['model_manager_name']);

        if (isset($config['resources'])) {
            $this->createResourceServices($config['resources'], $container);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'symedit_widget';
    }
}
