<?php

namespace SymEdit\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class IsometriksSymEditExtension extends SymEditResourceExtension
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

        $container->setParameter('isometriks_symedit.model_manager_name', $config['model_manager_name']);
        $container->setParameter('isometriks_symedit.extensions.routes', $config['extensions']);
        $container->setParameter('isometriks_symedit.admin_dir', $config['admin_dir']);
    }

    public function getAlias()
    {
        return 'isometriks_symedit';
    }
}
