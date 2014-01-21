<?php

namespace Isometriks\Bundle\MediaBundle\Util;

class ImageManipulator
{
    protected $imageWriter;
    protected $webRoot;

    public function __construct(ImageWriterInterface $imageWriter, $webRoot)
    {
        $this->imageWriter = $imageWriter;
        $this->webRoot = $webRoot;
    }

    /**
     * Gets the ImageInfo object for an image source
     *
     * @param string $webPath
     * @return ImageInfo
     */
    protected function getImageInfo($webPath)
    {
        return ImageInfoFactory::getImageInfo($this->webRoot, $webPath);
    }

    protected function getArgument(array $names, array $args)
    {
        foreach ($names as $name) {
            if (isset($args[$name])) {
                return $args[$name];
            }
        }

        return null;
    }

    public function constrain($webPath, $args)
    {
        try {
            $imageInfo = $this->getImageInfo($webPath);
        } catch (\InvalidArgumentException $e) {
            return $e->getMessage();
        }

        $height = $imageInfo->getHeight();
        $width = $imageInfo->getWidth();
        $ratio = $imageInfo->getRatio();

        // Get Arguments
        $newWidth = $this->getArgument(array('width', 'w'), $args);
        $newHeight = $this->getArgument(array('height', 'h'), $args);

        /**
         * Both dimensions supplied
         */
        if ($newWidth !== null && $newHeight !== null) {
            $widthRatio = $newWidth / $width;

            if ($width <= $newWidth && ($height <= $newHeight)) {
                $newWidth = $newHeight = null;
            } elseif ($widthRatio * $height < $newHeight) {
                $newHeight = null;
            } else {
                $newWidth = null;
            }
        }

        /**
         * Width supplied
         */
        if ($newWidth !== null) {

            // No adjustments need to be made, return original image
            if ($width < $newWidth) {
                return $webPath;
            }

            $newHeight = $newWidth / $ratio;

        /**
         * Height Supplied
         */
        } elseif ($newHeight !== null) {

            // No Adjustments need to be made, return original
            if ($height < $newHeight) {
                return $webPath;
            }

        /**
         * Both null, or both already constrained, return original
         */
        } else {
            return $webPath;
        }

        /**
         * Adjust our image info to match the new dimensions
         */
        $imageInfo->setDestinationHeight($newHeight);
        $imageInfo->setDestinationWidth($newWidth);

        /**
         * If Image already exists just return it
         */
        if ($imageInfo->getCacheFileExists()) {
            return $imageInfo->getCacheSrc();
        }

        /**
         * Create the new image
         */
        $this->imageWriter->createCacheImage($imageInfo);

        return $imageInfo->getCacheSrc();
    }
}