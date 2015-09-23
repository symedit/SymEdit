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

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SymEditWidgetExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    protected $configFiles = array(
        'services.xml',
        'widget.xml',
        'form.xml',
    );

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->configure(
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

    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('symedit')) {
            return;
        }

        $container->prependExtensionConfig('symedit', array(
            'template_locations' => array(
                '@SymEditWidgetBundle/Resources/views',
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'symedit_widget';
    }
}
