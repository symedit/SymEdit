<?php

namespace Isometriks\Bundle\MediaBundle\Util;

class GDImageWriter implements ImageWriterInterface
{
    public function createCacheImage(ImageInfo $imageInfo)
    {
        $newWidth = $imageInfo->getDestinationWidth();
        $newHeight = $imageInfo->getDestinationHeight();

        $image = $this->loadImage($imageInfo);
        $resized = \imagecreatetruecolor($newWidth, $newHeight);

        \imagealphablending($resized, false);
        \imagesavealpha($resized, true);

        \imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $imageInfo->getWidth(), $imageInfo->getHeight());

        $cacheFile = $imageInfo->getAbsoluteCacheSrc();

        \imagepng($resized, $cacheFile);
        
        chmod($cacheFile, 0644);
    }

    protected function loadImage(ImageInfo $imageInfo)
    {
        $contents = file_get_contents($imageInfo->getAbsolutePath());

        return \imagecreatefromstring($contents);
    }
}