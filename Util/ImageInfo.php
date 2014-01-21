<?php

namespace Isometriks\Bundle\MediaBundle\Util;

class ImageInfo
{
    protected $webRoot;
    protected $webPath;
    protected $width;
    protected $height;
    protected $destinationWidth;
    protected $destinationHeight;
    protected $type;
    protected $cacheDir = 'cache';

    public function getWebRoot()
    {
        return $this->webRoot;
    }

    public function getWebPath()
    {
        return $this->webPath;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDestinationWidth()
    {
        return $this->destinationWidth;
    }

    public function getDestinationHeight()
    {
        return $this->destinationHeight;
    }

    public function getRatio()
    {
        if ($this->getHeight() == 0) {
            throw new \Exception('Invalid / Division by 0 ratio');
        }

        return $this->getWidth() / $this->getHeight();
    }

    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    public function getCacheSrc()
    {
        $pathInfo = pathinfo($this->getWebPath());
        $pattern = '%s/%s/%s_%dx%d.%s';

        $width = $this->getDestinationWidth() === null ? $this->getWidth() : $this->getDestinationWidth();
        $height = $this->getDestinationHeight() === null ? $this->getHeight() : $this->getDestinationHeight();

        return sprintf($pattern, $pathInfo['dirname'], $this->getCacheDir(), $pathInfo['filename'],
                                 $width, $height,
                                 'png');
    }

    public function getAbsoluteCacheSrc()
    {
        return $this->webRoot . DIRECTORY_SEPARATOR . $this->getCacheSrc();
    }

    public function getCacheFileExists()
    {
        return file_exists($this->getCacheSrc());
    }

    public function getAbsolutePath()
    {
        return $this->webRoot . DIRECTORY_SEPARATOR . $this->webPath;
    }

    public function setWebRoot($webRoot)
    {
        $this->webRoot = $webRoot;

        return $this;
    }

    public function setWebPath($webPath)
    {
        $this->webPath = $webPath;

        return $this;
    }

    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function setDestinationWidth($destinationWidth)
    {
        $this->destinationWidth = $destinationWidth;

        return $this;
    }

    public function setDestinationHeight($destinationHeight)
    {
        $this->destinationHeight = $destinationHeight;

        return $this;
    }

    public function setCacheDir($cacheDir)
    {
        $this->cacheDir = $cacheDir;

        return $this;
    }
}
