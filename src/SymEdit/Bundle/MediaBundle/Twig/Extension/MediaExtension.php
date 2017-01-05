<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Twig\Extension;

use SymEdit\Bundle\MediaBundle\Model\MediaInterface;

class MediaExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('symedit_media_size', [$this, 'getSize']),
        ];
    }

    public function getSize(MediaInterface $media)
    {
        $metadata = $media->getMetadata();

        if (!isset($metadata[MediaInterface::META_FILESIZE])) {
            return 'Unknown';
        }

        $size = $metadata[MediaInterface::META_FILESIZE] / 1024 / 1024;
        $formatted = number_format($size, 1);

        // Don't display 0MB
        if ($size < 1) {
            $formatted = '<1';
        }

        return sprintf('%sMB', $formatted);
    }

    public function getName()
    {
        return 'symedit_media';
    }
}
