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
    protected $paths;

    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    public function getMediaPath($type, MediaInterface $media)
    {
        if (!isset($this->paths[$type])) {
            throw new \InvalidArgumentException(sprintf('Cannot find path for type "%s"', $type));
        }

        $path = $this->paths[$type];

        return sprintf('%s/%s', $path, $media->getPath());
    }
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('media_*', array($this, 'getMediaPath')),
        );
    }

    public function getName()
    {
        return 'symedit_media';
    }
}
