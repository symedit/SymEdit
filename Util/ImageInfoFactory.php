<?php

namespace Isometriks\Bundle\MediaBundle\Util;

class ImageInfoFactory
{
    /**
     *
     * @param string $src
     * @return ImageInfo Images information
     * @throws \InvalidArgumentException
     */
    public static function getImageInfo($webRoot, $webPath)
    {
        $src = $webRoot . DIRECTORY_SEPARATOR . $webPath;

        if (!file_exists($src) || !is_readable($src)) {
            throw new \InvalidArgumentException(sprintf('Could not open "%s"', $src));
        }

        if (($size = getimagesize($src)) === false) {
            throw new \InvalidArgumentException(sprintf('File "%s" is not an image"', $src));
        }

        list($width, $height, $type) = $size;

        $imageInfo = new ImageInfo();
        $imageInfo->setWebRoot($webRoot);
        $imageInfo->setWebPath($webPath);
        $imageInfo->setWidth($width);
        $imageInfo->setHeight($height);
        $imageInfo->setType($type);

        return $imageInfo;
    }
}