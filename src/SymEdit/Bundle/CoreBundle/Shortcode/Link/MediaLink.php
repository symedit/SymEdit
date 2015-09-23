<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Shortcode\Link;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Routing\RouterInterface;

class MediaLink implements LinkInterface
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function generate(RouterInterface $router, array $attributes)
    {
        $id = $attributes['media-id'];
        $media = $this->repository->find($id);

        if ($media) {
            return $media->getWebPath();
        }
    }

    public function supports(array $attributes)
    {
        return isset($attributes['media-id']);
    }
}
