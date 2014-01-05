<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Isometriks\Bundle\SymEditBundle\Event\Events;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Isometriks\Bundle\SymEditBundle\Event\PostEvent;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;

/**
 * @TODO: Need to fix this..
 */
class ViewCountSubscriber implements EventSubscriberInterface
{
    protected $pageRepository;
    protected $postRepository;

    public function __construct(RepositoryInterface $pageRepository, RepositoryInterface $postRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->postRepository = $postRepository;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::PAGE_VIEW => 'pageView',
            Events::POST_VIEW => 'postView',
        );
    }

    public function pageView(ResourceEvent $event)
    {
        $page = $event->getSubject();

        /**
         * Add View
         */
        $page->addView();
        //$this->pageRepository->updatePage($page);
    }

    public function postView(PostEvent $event)
    {
        $post = $event->getPost();

        /**
         * Add View
         */
        $post->addView();
        //$this->postRepository->updatePost($post);
    }
}