<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\DependencyInjection;

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SymEditMediaExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    protected $configFiles = array(
        'services', 'form', 'widget',
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

        $this->remapParameters($container, 'paths', $config['paths']);
        $container->setParameter('symedit_media.paths', $config['paths']);
        $container->setParameter('symedit_media.namer', $config['namer']);

        $container->setAlias('symedit_media.namer', $config['namer']);
    }

    public function prepend(ContainerBuilder $container)
    {
        /**
         * Twig Extension
         */
        $container->prependExtensionConfig('twig', array(
            'form' => array(
                'resources' => array(
                    'SymEditMediaBundle:Form:fields.html.twig',
                ),
            ),
        ));

        if ($container->hasExtension('symedit')) {
            $container->prependExtensionConfig('symedit', array(
                'template_locations' => array(
                    '@SymEditMediaBundle/Resources/views',
                ),
            ));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'symedit_media';
    }
}
