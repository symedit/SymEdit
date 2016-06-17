<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Image controller.
 */
class ImageController extends MediaController
{
    public function jsonAction()
    {
        $images = $this->getRepository()->findAll();
        $out = [];

        foreach ($images as $image) {
            $out[] = [
                'id' => $image->getId(),
                'thumb' => $this->getThumbnail($image->getPath()),
                'image' => $image->getWebPath(),
            ];
        }

        return new JsonResponse($out);
    }

    protected function getThumbnail($path, $size = 'symedit_64x64')
    {
        $this->container->get('liip_imagine.controller')->filterAction(
            $this->getRequest(),
            $path,
            $size
        );

        $cacheManager = $this->container->get('liip_imagine.cache.manager');

        return $cacheManager->getBrowserPath($path, $size);
    }
}
