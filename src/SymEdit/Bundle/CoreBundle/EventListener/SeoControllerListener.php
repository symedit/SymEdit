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

use SymEdit\Bundle\SeoBundle\Model\SeoManagerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Checks for a _page attribute in the request and sets that by default
 * to be the SEO, overwrite it in your controllers.
 */
class SeoControllerListener
{
    private $seoManager;

    public function __construct(SeoManagerInterface $seoManager)
    {
        $this->seoManager = $seoManager;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $attributes = $request->attributes;

        if ($attributes->has('_page')) {
            $seo = $this->seoManager->getSeo();
            $seo->setSubject($attributes->get('_page'));
        }
    }
}
