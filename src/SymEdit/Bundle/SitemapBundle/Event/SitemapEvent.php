<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SitemapBundle\Event;

use SymEdit\Bundle\SitemapBundle\Model\Sitemap;
use Symfony\Component\EventDispatcher\Event;

class SitemapEvent extends Event
{
    protected $sitemap;

    public function __construct(Sitemap $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    /**
     * @return Sitemap
     */
    public function getSitemap()
    {
        return $this->sitemap;
    }

    public function setSitemap(Sitemap $sitemap)
    {
        $this->sitemap = $sitemap;

        return $this;
    }
}
