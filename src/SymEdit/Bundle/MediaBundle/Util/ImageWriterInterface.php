<?php

namespace Isometriks\Bundle\MediaBundle\Util;

interface ImageWriterInterface
{
    public function createCacheImage(ImageInfo $imageInfo);
}