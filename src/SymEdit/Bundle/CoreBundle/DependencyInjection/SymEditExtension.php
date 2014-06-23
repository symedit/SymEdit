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
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SymEditExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    protected $configFiles = array(
        'services', 'widget', 'routing', 'form',
        'event', 'twig', 'util', 'profiler',
        'menu', 'seo', 'report', 'shortcode',
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

    public function prepend(ContainerBuilder $container)
    {
        /**
         * FOS User Prepend
         */
        $container->prependExtensionConfig('fos_user', array(
            'firewall_name' => 'main',
            'service' => array(
                'mailer' => 'symedit.mailer',
            ),
            'registration' => array(
                'confirmation' => array(
                    'enabled' => true,
                    'template' => '@SymEdit/Email/confirm.html.twig',
                ),
            ),
            'resetting' => array(
                'email' => array(
                    'template' => '@SymEdit/Email/resetting.html.twig',
                ),
            ),
        ));
    }

    public function getAlias()
    {
        return 'symedit';
    }
}
