<?php

namespace SymEdit\Bundle\ThemeBundle\Theme\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlThemeLoader extends FileLoader
{
    public function load($resource, $type = null)
    {
        $file = $this->getLocator()->locate($resource);

        return Yaml::parse(file_get_contents($file));
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}