<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\DependencyInjection;

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SymEditFormBuilderExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    protected $configFiles = array(
        'services.xml',
        'fields.xml',
        'widget.xml',
    );

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->configure(
            $config,
            new Configuration(),
            $container,
            self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS
        );

        $container->setParameter('symedit_form_builder.action_route', $config['action_route']);
    }

    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('symedit')) {
            return;
        }

        $container->prependExtensionConfig('symedit', array(
            'template_locations' => array(
                '@SymEditFormBuilderBundle/Resources/views',
            ),
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'symedit_form_builder';
    }
}
