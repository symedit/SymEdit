<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Upload;

use Gaufrette\Filesystem;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;

/**
 * Image Uploader - Basically the same as the uploader except this one
 * will help us to clear LiipImagineBundle cached images when we upload
 * a new one.
 */
class ImageUploadManager extends UploadManager
{
    protected $cache;
    protected $filters;

    public function __construct(Filesystem $filesystem, MetadataTagger $metadataTagger, CacheManager $cache)
    {
        $this->cache = $cache;

        parent::__construct($filesystem, $metadataTagger);
    }
    
    public function removeUpload(MediaInterface $media)
    {
        // Image is new
        if ($media->getPath() === null) {
            return;
        }

        parent::removeUpload($media);

        // Remove from Imagine cache
        $this->cache->remove($media->getPath());
    }
}
