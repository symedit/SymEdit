<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Sylius\Component\Resource\Repository\RepositoryInterface;

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
        $pageId = $request->attributes->get('_page_id', null);

        if (!empty($pageId)) {
            $request->attributes->remove('_page_id');
            $page = $this->pageRepository->find($pageId);
        } else {
            $page = $this->pageRepository->createNew();
            $page->setPath($request->getPathInfo());
        }

        // Add it to the request
        $request->attributes->add(array(
            '_page' => $page,
        ));
    }
}
