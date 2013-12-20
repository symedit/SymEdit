<?php

namespace Isometriks\Bundle\SymEditBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\SyliusResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class IsometriksSymEditExtension extends SyliusResourceExtension
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

    /**
     * Remap class parameters.
     *
     * @param array            $classes
     * @param ContainerBuilder $container
     */
    protected function mapClassParameters(array $classes, ContainerBuilder $container)
    {
        foreach ($classes as $model => $serviceClasses) {
            foreach ($serviceClasses as $service => $class) {
                $container->setParameter(sprintf('isometriks_symedit.%s.%s.class', $service === 'form' ? 'form.type' : $service, $model), $class);
            }
        }
    }

    /**
     * Maps parameters to their equivalent path in their arrays
     *
     * @param ContainerBuilder $container
     * @param string $path
     * @param array $config
     */
    private function remapParameters(ContainerBuilder $container, $path, array $config)
    {
        $prefix = rtrim($this->getAlias().'.'.$path, '.');

        foreach ($config as $key => $value) {
            $container->setParameter(sprintf('%s.%s', $prefix, $key), $value);
        }
    }

    public function getAlias()
    {
        return 'isometriks_symedit';
    }
}
