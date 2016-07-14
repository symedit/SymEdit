<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Widget\Strategy;

use SymEdit\Bundle\BlogBundle\Repository\PostRepositoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\AbstractWidgetStrategy;

abstract class AbstractPostStrategy extends AbstractWidgetStrategy
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getCacheOptions(WidgetInterface $widget)
    {
        $latestPost = $this->postRepository->getLatestPost();

        // No posts
        if (!$latestPost) {
            return parent::getCacheOptions($widget);
        }

        // Return when latest post was modified
        return [
            'public' => true,
            'last_modified' => $latestPost->getUpdatedAt(),
        ];
    }
}
