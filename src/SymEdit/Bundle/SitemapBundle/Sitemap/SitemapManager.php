<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SitemapBundle\Sitemap;

use SymEdit\Bundle\SitemapBundle\Model\Sitemap;

class SitemapManager
{
    protected $fetcher;
    protected $models;

    public function __construct(SitemapFetcher $fetcher, $models)
    {
        $this->fetcher = $fetcher;
        $this->models = $models;
    }

    public function getModels()
    {
        return $this->models;
    }

    public function setModels(array $models)
    {
        $this->models = $models;

        return $this;
    }

    public function getSitemap()
    {
        $sitemap = new Sitemap();
        foreach ($this->getModels() as $className => $parameters) {
            array_map([$sitemap, 'addEntry'], $this->fetcher->fetchEntries($className, $parameters));
        }

        return $sitemap;
    }
}
