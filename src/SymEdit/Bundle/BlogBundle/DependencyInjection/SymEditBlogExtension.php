<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\DependencyInjection;

use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SymEditBlogExtension extends SymEditResourceExtension implements PrependExtensionInterface
{
    protected $configFiles = array(
        'form.xml', 'widget.xml',
    );

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configure(
            $config,
            new Configuration(),
            $container,
            self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS
        );
    }

    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('symedit')) {
            return;
        }

        $container->prependExtensionConfig('symedit', array(
            'template_locations' => array(
                '@SymEditBlogBundle/Resources/views',
            ),
        ));
    }

    public function getAlias()
    {
        return 'symedit_blog';
    }
}
