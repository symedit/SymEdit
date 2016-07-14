<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Widget\Strategy;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\MediaBundle\Model\ImageGalleryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;

abstract class AbstractGalleryStrategy extends AbstractWidgetStrategy
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ImageGalleryInterface
     */
    protected function getGallery(WidgetInterface $widget)
    {
        return $this->repository->findOneBy([
            'slug' => $widget->getOption('slider'),
        ]);
    }

    public function getCacheOptions(WidgetInterface $widget)
    {
        return [
            'public' => true,
            'last_modified' => $this->getGallery($widget)->getUpdatedAt(),
        ];
    }
}
