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

use Sylius\Component\Resource\Factory\FactoryInterface;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\CoreBundle\Repository\PageRepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Checks the request for a _page_id, and then adds the actual Page
 * to the Request instead.
 */
class CurrentPageListener
{
    private $container;
    private $pageRepository;
    private $pageFactory;

    public function __construct(ContainerInterface $container, PageRepositoryInterface $pageRepository, FactoryInterface $pageFactory)
    {
        $this->container = $container;
        $this->pageRepository = $pageRepository;
        $this->pageFactory = $pageFactory;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->has('_page')) {
            $this->updateContainer($request->attributes->get('_page'));

            return;
        }

        $pageId = $request->attributes->get('_page_id', null);

        if (!empty($pageId)) {
            $request->attributes->remove('_page_id');
            $page = $this->pageRepository->find($pageId);
        } else {
            $page = $this->pageFactory->createNew();
            $page->setPath($request->getPathInfo());
        }

        // Add it to the request
        $request->attributes->add([
            '_page' => $page,
        ]);

        // Add to container
        $this->updateContainer($page);
    }

    private function updateContainer(PageInterface $page)
    {
        $this->container->set('symedit_page', $page);
    }
}
