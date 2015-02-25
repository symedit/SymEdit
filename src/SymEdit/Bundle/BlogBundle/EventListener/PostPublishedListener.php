<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\EventListener;

use Sylius\Component\Resource\Event\ResourceEvent;
use SymEdit\Bundle\BlogBundle\Model\PostInterface;

/**
 * Doctrine extensions isn't working well with have an on create
 * and on change timestampable so this solves creating a new published
 * post directly.
 */
class PostPublishedListener
{
    public function onPostCreate(ResourceEvent $event)
    {
        $post = $event->getSubject();

        if (!$post instanceof PostInterface) {
            return;
        }

        if ($post->isPublished()) {
            $post->setPublishedAt(new \DateTime());
        }
    }
}
