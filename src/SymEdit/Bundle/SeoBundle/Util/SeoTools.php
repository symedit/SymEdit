<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\Util;

class SeoTools
{
    public function limit($length, $showElipsis, $elipsis = '...')
    {
        // idk
    }

    /**
     * Removes XSS issues mostly, html entities and strip_tags.
     *
     * @param string $string
     *
     * @return string
     */
    public static function normalize($string)
    {
        return htmlentities(strip_tags($string), ENT_COMPAT, 'UTF-8', false);
    }

    /**
     * Removes outer whitespace, and removes double spaces / newlines.
     *
     * @param string $string
     */
    public static function minify($string)
    {
        return trim(preg_replace('#\s+#', ' ', $string));
    }

    /**
     * Normalize then minify.
     *
     * @param string $string
     *
     * @return string
     */
    public static function plain($string, $length = null)
    {
        $normal = self::normalize($string);
        $minify = self::minify($normal);

        return $length === null ? $minify : substr($minify, 0, $length);
    }
}
