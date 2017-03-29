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
            new \Twig_SimpleFilter('symedit_media_attr', [$this, 'getAttributes'], ['is_safe' => ['html']]),
        ];
    }

    public function getSize(MediaInterface $media)
    {
        $metadata = $media->getMetadata();

        if (!isset($metadata[MediaInterface::META_FILESIZE])) {
            return 'Unknown';
        }

        $bytes = $metadata[MediaInterface::META_FILESIZE];
        $sizes = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf('%.1f %s', $bytes / pow(1024, $factor), $sizes[$factor]);
    }

    public function getAttributes(MediaInterface $media)
    {
        $attr = '';
        $metadata = $media->getMetadata();

        if (isset($metadata[MediaInterface::META_WIDTH])) {
            $attr .= sprintf('width="%d"', $metadata[MediaInterface::META_WIDTH]);
        }

        if (isset($metadata[MediaInterface::META_HEIGHT])) {
            $attr .= sprintf(' height="%d"', $metadata[MediaInterface::META_HEIGHT]);
        }

        return trim($attr);
    }

    public function getName()
    {
        return 'symedit_media';
    }
}
