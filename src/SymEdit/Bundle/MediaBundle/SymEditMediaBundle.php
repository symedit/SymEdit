<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use SymEdit\Bundle\MediaBundle\DependencyInjection\Compiler\GalleryItemFactoryCompilerPass;
use SymEdit\Bundle\MediaBundle\DependencyInjection\SymEditMediaExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SymEditMediaBundle extends AbstractResourceBundle
{
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    protected function getModelInterfaces()
    {
        return [
            'SymEdit\Bundle\MediaBundle\Model\ImageInterface' => 'symedit.model.image.class',
            'SymEdit\Bundle\MediaBundle\Model\FileInterface' => 'symedit.model.file.class',
            'SymEdit\Bundle\MediaBundle\Model\ImageGalleryInterface' => 'symedit.model.image_gallery.class',
            'SymEdit\Bundle\MediaBundle\Model\GalleryItemInterface' => 'symedit.model.gallery_item.class',
        ];
    }

    protected function getModelNamespace()
    {
        return 'SymEdit\Bundle\MediaBundle\Model';
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new GalleryItemFactoryCompilerPass());
    }

    protected function getBundlePrefix()
    {
        return 'symedit_media';
    }

    public function getContainerExtension()
    {
        return new SymEditMediaExtension();
    }
}
