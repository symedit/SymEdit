<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\Model;

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

    public function getSubject();

    public function setSubject($subject, $replace = true);
}