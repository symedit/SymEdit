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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymEdit\Bundle\ResourceBundle\DependencyInjection\SymEditResourceExtension;

class SymEditBlogExtension extends SymEditResourceExtension
{
    protected $configFiles = array(
        'services', 'form', 'widget',
    );

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $this->configDir = __DIR__.'/../Resources/config';

        list($config) = $this->configure($config, new Configuration(), $container, self::CONFIGURE_LOADER | self::CONFIGURE_DATABASE | self::CONFIGURE_PARAMETERS);

        $container->setParameter('symedit_blog.model_manager_name', $config['model_manager_name']);

        if (isset($config['resources'])) {
            $this->createResourceServices($config['resources'], $container);
        }
    }

    public function getAlias()
    {
        return 'symedit_blog';
    }
}
