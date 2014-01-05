<?php

namespace SymEdit\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class SymEditExtension extends SymEditResourceExtension
{
    protected $configFiles = array(
        'services', 'user', 'widget', 'routing',
        'form', 'event', 'twig', 'util', 'profiler',
        'menu', 'seo', 'controllers',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->configDir = __DIR__.'/../Resources/config/';

        list($config, $loader) = $this->configure($configs, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS);

        $this->remapParameters($container, 'email', $config['email']);
        $this->remapParameters($container, 'fragment', $config['fragment']);

        $container->setParameter('symedit.model_manager_name', $config['model_manager_name']);
        $container->setParameter('extensions.routes', $config['extensions']);
        $container->setParameter('symedit.admin_dir', $config['admin_dir']);
    }

    public function getAlias()
    {
        return 'symedit';
    }
}
