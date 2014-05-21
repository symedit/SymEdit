<?php

namespace SymEdit\Bundle\ShortcodeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sym_edit_shortcode');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        /**
         * symedit_shortcode:
         *     options:
         *          icon: fontawesome4     // symedit_shortcode.options.icon
         *          bootstrap:
         *              default_size: md
         *
         * Settings:
         *
         * shortcode:
         *     settings:
         *         bootstrap:
         *             type: shortcode_bootstrap_settings
         *
         * BootstrapSettingsType
         * {
         *     public function buildForm($builder)
         *     {
         *         $builder->add('default_size', 'choice', array('choices' => array('xs', 'sm', 'md', 'lg'));
         *         $builder->add('icon', 'choice', array(
         *             '<i class="icon-%s"></i>' => 'FontAwesome 3.x',
         *             ... etc..
         *         ));
         *     }
         *
         *     extend: json_settings
         * }
         *
         * ....Shortode ($data)
         * {
         *     return sprintf($this->options->pattern, ...);
         * }
         *
         * The json_settings would have a data transformer. You could only ever get settings('group.setting') then you'd have to do $setting['default_size'] or whatever.
         * Shit. You'd have to deserialize the settings when you loaded them... Or
         */

        return $treeBuilder;
    }
}
