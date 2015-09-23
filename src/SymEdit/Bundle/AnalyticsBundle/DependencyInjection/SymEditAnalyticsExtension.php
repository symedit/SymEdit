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

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SymEditAnalyticsExtension extends SymEditResourceExtension
{
    protected $configFiles = array(
        'services.xml', 'report.xml',
    );

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configure(
            $config,
            new Configuration(),
            $container,
            self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS
        );
    }

    public function process(array $config, ContainerBuilder $container)
    {
        $container->setParameter('symedit_analytics.tracker.models', $config['tracker']);

        return $config;
    }

    public function getAlias()
    {
        return 'symedit_analytics';
    }
}
