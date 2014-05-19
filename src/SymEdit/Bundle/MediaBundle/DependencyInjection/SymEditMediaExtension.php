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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;

class SymEditMediaExtension extends SymEditResourceExtension
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
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'symedit_media';
    }
}
