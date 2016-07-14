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

use SymEdit\Bundle\CoreBundle\Model\BreadcrumbsInterface;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernel;

class BreadcrumbSubscriber implements EventSubscriberInterface
{
    protected $breadcrumbs;

    public function __construct(BreadcrumbsInterface $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => ['buildPageCrumbs', 0],
        ];
    }

    public function buildPageCrumbs(FilterControllerEvent $event)
    {
        if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();

        if ($request->attributes->has('_page')) {
            /* @var $page PageInterface */
            $page = $request->attributes->get('_page');

            while ($page->getParent() !== null && !$page->getHomepage()) {
                $this->breadcrumbs->unshift($page->getTitle(), $page->getRoute());

                $page = $page->getParent();
            }
        }

        $request->attributes->add([
            '_breadcrumbs' => $this->breadcrumbs,
        ]);
    }
}
