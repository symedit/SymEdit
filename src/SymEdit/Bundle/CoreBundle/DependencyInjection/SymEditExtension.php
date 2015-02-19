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
        'menu', 'seo', 'report', 'shortcode',
        'cache',
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
        $container->setParameter('symedit.template_locations', $config['template_locations']);
        $container->setParameter('symedit.extensions.routes', $config['extensions']);

        // Process Assetic Configurations
        $this->processResources($container, $config['assets']);

        // Process routing Config
        $pageControllers = $this->findBundleResources($container, '/Resources/config/symedit/page_controllers.yml');
        $container->setParameter('symedit.routing.loader.resources', $pageControllers);
        $container->setParameter('symedit.routing.route_uri_filter_regexp', $config['routing']['route_uri_filter_regexp']);
    }

    /**
     * Setup @symedit_stylesheets and @symedit_javascripts to be used in the admin,
     * they can be added either in the config or in the prependExtension so you
     * can add new sheets/scripts without changing the templates.
     */
    protected function processResources(ContainerBuilder $container, array $resources)
    {
        $formulae = array();

        foreach ($resources as $name => $assets) {
            $formulae['symedit_'.$name] = array($assets, array(), array());
        }

        $container->getDefinition('symedit.assetic.config_resource')->replaceArgument(0, $formulae);
    }

    public function getAlias()
    {
        return 'symedit';
    }
}
