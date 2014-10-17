<?php

namespace SymEdit\Bundle\CoreBundle\Routing\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlPageControllerLoader extends FileLoader
{
    public function load($resource, $type = null)
    {
        return Yaml::parse(file_get_contents($resource));
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}
