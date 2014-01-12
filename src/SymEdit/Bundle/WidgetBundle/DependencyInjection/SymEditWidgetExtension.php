<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SymEditWidgetExtension extends SymEditResourceExtension
{
    protected $configFiles = array(
        'services', 'widget', 'form',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configDir = __DIR__.'/../Resources/config';

        list($config) = $this->configure($config, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS);

        $container->setParameter('symedit_widget.model_manager_name', $config['model_manager_name']);
        $this->remapParameters($container, 'fragment', $config['fragment']);

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
