<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ResourceBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class SymEditResourceExtension extends AbstractResourceExtension
{
    protected $applicationName = 'symedit';

    /**
     * Maps parameters to their equivalent path in their arrays.
     *
     * @param ContainerBuilder $container
     * @param string           $path
     * @param array            $config
     */
    protected function remapParameters(ContainerBuilder $container, $path, array $config)
    {
        $prefix = rtrim($this->getAlias().'.'.$path, '.');

        foreach ($config as $key => $value) {
            $container->setParameter(sprintf('%s.%s', $prefix, $key), $value);
        }
    }

    protected function findBundleResources(ContainerBuilder $container, $pattern)
    {
        $bundles = $container->getParameter('kernel.bundles');
        $files = [];

        foreach ($bundles as $bundle) {
            $class = new \ReflectionClass($bundle);
            $dir = dirname($class->getFileName());
            $file = $dir.'/'.ltrim($pattern, '/');
            if (file_exists($file)) {
                $files[] = $file;
            }
        }

        return $files;
    }
}
