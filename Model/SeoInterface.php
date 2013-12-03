<?php

namespace Isometriks\Bundle\SeoBundle\Model;

interface SeoInterface extends SeoAbleInterface
{
    /**
     * Adds a meta tag
     */
    public function addMeta($type, $key, $content);

    /**
     * Check if meta exists
     *
     * @return boolean
     */
    public function hasMeta($type, $key = null);
}