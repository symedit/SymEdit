<?php

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