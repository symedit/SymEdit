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
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadManager implements UploadManagerInterface
{
    protected $filesystem;
    protected $metadataTagger;

    public function __construct(Filesystem $filesystem, MetadataTagger $metadataTagger)
    {
        $this->filesystem = $filesystem;
        $this->metadataTagger = $metadataTagger;
    }

    /**
     * Prepare file for upload.
     */
    public function preUpload(MediaInterface $media)
    {
        if (($callback = $media->getNameCallback()) !== null) {
            $media->setName($callback($media));
        }

        if (($file = $media->getFile()) !== null) {
            // Remove old upload
            $this->removeUpload($media);

            // Set metadata
            $this->metadataTagger->tag($media, $file);
        }
    }

    /**
     * Uploads the file.
     *
     * @param MediaInterface $media
     */
    public function upload(MediaInterface $media)
    {
        $file = $media->getFile();

        if (!$file instanceof UploadedFile) {
            return;
        }

        $this->filesystem->write(
            $media->getPath(),
            file_get_contents($file->getFileInfo()->getPathname())
        );

        // Mark as null to not upload again
        $media->setFile(null);
    }

    public function removeUpload(MediaInterface $media)
    {
        if ($media->getPath() === null) {
            return;
        }

        if ($this->filesystem->has($media->getPath())) {
            $this->filesystem->delete($media->getPath());
        }
    }
}
