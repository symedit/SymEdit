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
            list($width, $height) = getimagesize($file->getPathname());

            $metadata = array_merge($metadata, [
                MediaInterface::META_WIDTH => $width,
                MediaInterface::META_HEIGHT => $height,
            ]);
        }

        $media->setMetadata($metadata);
    }
}
