<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class WidgetAssociationTransformer implements DataTransformerInterface
{
    /**
     * Split the textarea by newlines, or commas and trim extra space.
     *
     * @param type $value
     *
     * @return type
     */
    public function reverseTransform($value)
    {
        $list = array_map('trim', preg_split('#\n|,#', $value));

        $filtered = array_filter($list, function ($item) {
            return !empty($item);
        });

        return array_values($filtered);
    }

    public function transform($value)
    {
        if ($value === null || !is_array($value)) {
            return '';
        }

        return implode("\n", $value);
    }
}
