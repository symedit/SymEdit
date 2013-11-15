<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Isometriks\Bundle\SymEditBundle\Event\Events;
use Isometriks\Bundle\SymEditBundle\Event\PageEvent;
use Isometriks\Bundle\SymEditBundle\Event\PostEvent;
use Isometriks\Bundle\SymEditBundle\Model\PostManagerInterface;
use Isometriks\Bundle\SymEditBundle\Model\PageManagerInterface;

class ViewCountSubscriber implements EventSubscriberInterface
{
    protected $pageManager;
    protected $postManager;

    public function __construct(PageManagerInterface $pageManager, PostManagerInterface $postManager)
    {
        $this->pageManager = $pageManager;
        $this->postManager = $postManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::PAGE_VIEW => 'pageView',
            Events::POST_VIEW => 'postView',
        );
    }

    public function pageView(PageEvent $event)
    {
        $page = $event->getPage();

        /**
         * Add View
         */
        $page->addView();
        $this->pageManager->updatePage($page);
    }

    public function postView(PostEvent $event)
    {
        $post = $event->getPost();

        /**
         * Add View
         */
        $post->addView();
        $this->postManager->updatePost($post);
    }
}