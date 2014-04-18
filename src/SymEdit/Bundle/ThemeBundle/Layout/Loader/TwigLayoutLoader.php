<?php

namespace SymEdit\Bundle\ThemeBundle\Layout\Loader;

use SymEdit\Bundle\ThemeBundle\Model\TemplateInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Yaml\Yaml;

class TwigLayoutLoader extends Loader
{
    public function load($resource, $type = null)
    {
        if (!$resource instanceof TemplateInterface) {
            return;
        }

        $contents = file_get_contents($resource->getPath());
        preg_match('%{#\s*``(.*?)``\s*#}%sm', $contents, $matches);

        if (count($matches) === 0) {
            return;
        }

        list($fullMatch, $yaml) = $matches;

        return Yaml::parse($yaml);
    }

    public function supports($resource, $type = null)
    {
        return $resource instanceof TemplateInterface && 'twig' === pathinfo(
            $resource->getPath(),
            PATHINFO_EXTENSION
        );
    }
}