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
        list($config) = $this->configure(
            $config,
            new Configuration(),
            $container,
            self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS
        );

        // Map Fragment Parameters
        $this->remapParameters($container, 'fragment', $config['fragment']);

        // Set Renderers
        $this->setupRenderers($container, $config['renderer']);
    }

    protected function setupRenderers(ContainerBuilder $container, array $renderers)
    {
        foreach (array('widget', 'area') as $renderer) {
            $container->setAlias(sprintf('symedit_widget.renderer.%s.default', $renderer), $renderers[$renderer]);
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
