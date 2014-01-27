<?php

namespace SymEdit\Bundle\MediaBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class GalleryItemDataTransformer implements DataTransformerInterface
{
    public function reverseTransform($value)
    {
        if (!isset($value['selected']) || !$value['selected']) {
            return null;
        }

        return $value['id'];
    }

    public function transform($value)
    {
        return $value;
    }
}