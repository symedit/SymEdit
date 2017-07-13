<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\VersionStrategy;

use SymEdit\Bundle\StylizerBundle\Dumper\VersionManager;
use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;

class StylizerVersionStrategy implements VersionStrategyInterface
{
    private $versionManager;

    public function __construct(VersionManager $versionManager)
    {
        $this->versionManager = $versionManager;
    }

    public function getVersion($path)
    {
        return $this->versionManager->getVersion();
    }

    public function applyVersion($path)
    {
        $versionized = sprintf('%s?%s', ltrim($path, '/'), $this->getVersion($path));

        if ($path && '/' == $path[0]) {
            return '/'.$versionized;
        }

        return $versionized;
    }
}
