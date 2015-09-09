<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\DependencyInjection;

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SymEditUserExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    protected $configFiles = array(
        'services.xml',
        'form.xml', 
        'notifications.xml',
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

        foreach ($config['notifications'] as $type => $notification) {
            if (!$notification['enabled']) {
                $container->removeDefinition('symedit_user.notification.'.$type);
            } else {
                $this->remapParameters($container, 'notifications.'.$type, $notification);
            }
        }
    }

    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('fos_user', array(
            'user_class' => '%symedit.model.user.class%',
            'service' => array(
                'user_manager' => 'symedit_user.user_manager',
            ),
            'registration' => array(
                'form' => array(
                    'type' => 'symedit_user_registration',
                ),
            ),
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'symedit_user';
    }
}
