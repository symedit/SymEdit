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
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class SymEditExtension extends SymEditResourceExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        // Load Driver
        $loader->load(sprintf('driver/%s.xml', $config['driver']));

        // Load Resources
        $this->registerResources('symedit', $config['driver'], $config['resources'], $container);

        // Load Config Files
        $configFiles = [
            'services.xml',
            'widget.xml',
            'routing.xml',
            'form.xml',
            'event.xml',
            'twig.xml',
            'profiler.xml',
            'menu.xml',
            'seo.xml',
            'report.xml',
            'shortcode.xml',
            'cache.xml',
            'settings.xml',
            'mailer.xml',
        ];


        foreach ($configFiles as $configFile) {
            $loader->load($configFile);
        }

        if (!empty($config['test'])) {
            $loader->load('test.xml');
        }

        $this->remapParameters($container, 'email', $config['email']);
        $container->setParameter('symedit.template_locations', $config['template_locations']);

        // Process Assetic Configurations
        $this->processAssets($container, $config['assets']);

        // Process routing Config
        $pageControllers = $this->findBundleResources($container, '/Resources/config/symedit/page_controllers.yml');
        $container->setParameter('symedit.routing.loader.resources', $pageControllers);
    }

    /**
     * Setup @symedit_stylesheets and @symedit_javascripts to be used in the admin,
     * they can be added either in the config or in the prependExtension so you
     * can add new sheets/scripts without changing the templates.
     */
    protected function processAssets(ContainerBuilder $container, array $resources)
    {
        $formulae = [];

        foreach ($resources as $name => $assets) {
            $formulae['symedit_'.$name] = [$assets, [], []];
        }

        $container->getDefinition('symedit.assetic.config_resource')->replaceArgument(0, $formulae);
    }

    public function getAlias()
    {
        return 'symedit';
    }
}
