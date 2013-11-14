<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Isometriks\Bundle\SymEditBundle\Model\PageManagerInterface;

/**
 * Checks the request for a _page_id, and then adds the actual Page
 * to the Request instead.
 */
class PageControllerListener
{
    private $pageManager;

    public function __construct(PageManagerInterface $pageManager)
    {
        $this->pageManager = $pageManager;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $attributes = $request->attributes;

        /**
         * Check if any request has a _page_id that needs to be converted
         */
        if($attributes->has('_page_id')){
            $id = $attributes->get('_page_id');
            $attributes->remove('_page_id');

            if(empty($id)){
                return;
            }

            $page = $this->pageManager->find($id);

            $attributes->add(array(
                '_page' => $page,
            ));
        }
    }
}