<?php

namespace SymEdit\Bridge\Media\Shortcode\Link;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\CoreBundle\Shortcode\Link\LinkInterface;
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