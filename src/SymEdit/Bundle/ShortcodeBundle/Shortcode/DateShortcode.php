<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ShortcodeBundle\Shortcode;

/**
 * Render date strings from current date / time
 */
class DateShortcode extends AbstractShortcode
{
    public function renderShortcode($match, array $attr, $content)
    {
        $date = new \DateTime();
        $pattern = current($attr);

        try {
            return $date->format($pattern);
        } catch (Exception $e) {
        }

        return;
    }

    public function getName()
    {
        return 'date';
    }
}
