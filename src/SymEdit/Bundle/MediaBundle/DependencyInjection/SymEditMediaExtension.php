<?php

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
        $this->configDir = __DIR__.'/../Resources/config';

        list($config) = $this->configure($config, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS);

        $this->remapParameters($container, 'paths', $config['paths']);
        $container->setParameter('symedit_media.paths', $config['paths']);
        $container->setParameter('symedit_media.model_manager_name', $config['model_manager_name']);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'symedit_media';
    }
}
