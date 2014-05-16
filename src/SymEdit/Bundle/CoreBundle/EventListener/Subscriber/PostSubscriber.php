<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\EventListener\Subscriber;

use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use SymEdit\Bundle\CoreBundle\Event\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;

class PostSubscriber implements EventSubscriberInterface
{
    protected $session;
    protected $router;

    public function __construct(Session $session, RouterInterface $router)
    {
        $this->session = $session;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::POST_POST_CREATE => 'sharePost',
            Events::POST_UPDATE      => 'sharePost',
        );
    }

    public function sharePost(ResourceEvent $event)
    {
        $this->addShare($event);
    }

    protected function addShare(ResourceEvent $event)
    {
        $post = $event->getSubject();

        if ($post->isPublished()) {
            try {
                $url = $this->router->generate('blog_slug_view', array('slug' => $post->getSlug()), true);
                $this->session->getFlashBag()->add('share', $url);
            } catch (RouteNotFoundException $e) {
                // The route to view posts doesn't exist, so we can't really share it.
            }
        }
    }
}