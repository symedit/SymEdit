<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\EventListener\Seo;

use SymEdit\Bundle\SeoBundle\Event\SeoEvent;
use SymEdit\Bundle\SeoBundle\Model\SeoCalculatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Checks to see if you added the _seo attribute to routing
 * or to the request dynamically. If it exists, overwrite
 * the current SEO
 */
class RequestCalculator implements SeoCalculatorInterface
{
    protected $request;

    /**
     * Set the Request
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * {@inheritDoc}
     */
    public function calculateSeo(SeoEvent $event)
    {
        if ($this->request === null || !$this->request->attributes->has('_seo')) {
            return;
        }

        $requestSeo = $this->request->attributes->get('_seo');
        $seo = $event->getSeo();

        $seo->merge($requestSeo, true);
    }
}