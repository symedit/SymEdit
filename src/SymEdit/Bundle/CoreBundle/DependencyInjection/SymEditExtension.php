<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DependencyInjection;

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SymEditExtension extends SymEditResourceExtension
{
    protected $configFiles = array(
        'services', 'widget', 'routing', 'form',
        'event', 'twig', 'util', 'profiler',
        'menu', 'seo', 'report',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        list($config) = $this->configure(
            $configs,
            new Configuration(),
            $container,
            self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS
        );

        $this->remapParameters($container, 'email', $config['email']);
        $container->setParameter('symedit.extensions.routes', $config['extensions']);
    }

    public function getAlias()
    {
        return 'symedit';
    }
}
