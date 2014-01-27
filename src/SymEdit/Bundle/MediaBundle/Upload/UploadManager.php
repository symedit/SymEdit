<?php

namespace SymEdit\Bundle\MediaBundle\Upload;

use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gaufrette\Filesystem;

class UploadManager implements UploadManagerInterface
{
    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Prepare file for upload
     */
    public function preUpload(MediaInterface $media)
    {
        if (($callback = $media->getNameCallback()) !== null) {
            $media->setName($callback($media));
        }

        if ($media->getFile() !== null) {
            $this->removeUpload($media);

            // Can do folders and stuff here.
            $media->setPath($media->getUploadName());
        }
    }

    /**
     * Uploads the file
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