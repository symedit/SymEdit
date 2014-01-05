<?php

namespace SymEdit\Bundle\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;

/**
 * Checks the request for a _page_id, and then adds the actual Page
 * to the Request instead.
 */
class PageControllerListener
{
    private $pageRepository;

    public function __construct(RepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
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

            $page = $this->pageRepository->find($id);

            $attributes->add(array(
                '_page' => $page,
            ));
        }
    }
}