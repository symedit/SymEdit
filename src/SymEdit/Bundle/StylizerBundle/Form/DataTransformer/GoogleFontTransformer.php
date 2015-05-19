<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class GoogleFontTransformer implements DataTransformerInterface
{
    /**
     * Split the textarea by newlines, or commas and trim extra space.
     *
     * @param type $value
     *
     * @return type
     */
    public function transform($value)
    {
        $values = trim($value, '"');
        $values = explode('|', $values);
        $values = array_map('urldecode', $values);

        return implode(', ', $values);
    }

    public function reverseTransform($value)
    {
        if ($value === null || empty($value)) {
            return 'none';
        }

        $values = explode(',', $value);
        $values = array_map('trim', $values);
        $values = array_map('urlencode', $values);

        return '"'.implode('|', $values).'"';
    }
}
