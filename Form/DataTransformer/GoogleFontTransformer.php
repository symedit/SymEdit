<?php

namespace Isometriks\Bundle\StylizerBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class GoogleFontTransformer implements DataTransformerInterface
{
    /**
     * Split the textarea by newlines, or commas and trim extra space
     *
     * @param type $value
     * @return type
     */
    public function transform($value)
    {
        if (!is_array($value)) {
            return '';
        }

        $values = array_map('urldecode', $value);
        return implode(',', $values);
    }

    public function reverseTransform($value)
    {
        if ($value === null || empty($value)) {
            return 'none';
        }

        $values = explode(',', $value);
        $values = array_map('trim', $values);
        $values = array_map('urlencode', $values);

        return implode('|', $values);
    }
}