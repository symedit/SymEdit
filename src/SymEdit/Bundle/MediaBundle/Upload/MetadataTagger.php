<?php

namespace SymEdit\Bundle\MediaBundle\Upload;

use SymEdit\Bundle\MediaBundle\Model\ImageInterface;
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use Symfony\Component\HttpFoundation\File\File;

class MetadataTagger
{
    public function tag(MediaInterface $media, File $file)
    {
        $metadata = [
            MediaInterface::META_FILESIZE => $file->getSize(),
        ];

        if ($media instanceof ImageInterface) {
            list ($width, $height) = getimagesize($file->getPathname());

            $metadata = array_merge($metadata, [
                MediaInterface::META_WIDTH => $width,
                MediaInterface::META_HEIGHT => $height,
            ]);
        }

        $media->setMetadata($metadata);
    }
}
