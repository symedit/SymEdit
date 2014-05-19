<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Layout\Loader;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Yaml\Yaml;

class TwigLayoutLoader extends Loader
{
    public function load($resource, $type = null)
    {
        $contents = file_get_contents($resource);
        preg_match('%{#\s*``(.*?)``\s*#}%sm', $contents, $matches);

        if (count($matches) === 0) {
            return;
        }

        list($fullMatch, $yaml) = $matches;

        return Yaml::parse($yaml);
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'twig' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}
