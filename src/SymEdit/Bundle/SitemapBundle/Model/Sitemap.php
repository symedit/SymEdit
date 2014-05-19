<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SitemapBundle\Model;

class Sitemap
{
    protected $entries;

    public function getEntries()
    {
        return $this->entries;
    }

    public function setEntries(array $entries)
    {
        $this->entries = $entries;
    }

    public function addEntry(array $entry)
    {
        $this->entries[] = $entry;
    }
}
