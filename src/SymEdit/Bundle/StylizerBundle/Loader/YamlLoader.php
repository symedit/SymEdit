<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Loader;

use Symfony\Component\Yaml\Yaml;

class YamlLoader implements LoaderInterface
{
    private $rootDir;
    private $yamlFiles;

    public function __construct($rootDir, array $yamlFiles = array())
    {
        $this->rootDir = $rootDir;
        $this->yamlFiles = $yamlFiles;
    }

    public function loadStyleData(ConfigData $configData)
    {
        foreach($this->yamlFiles as $file){
            $data = Yaml::parse(file_get_contents($file));

            foreach($data as $name => $value){
                $configData->parseGroup($name, $value);
            }
        }
    }
}