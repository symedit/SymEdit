<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\Storage;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class YamlStorage implements StorageInterface
{
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function load()
    {
        $data = is_file($this->file) && is_readable($this->file) ? Yaml::parse(file_get_contents($this->file)) : [];

        return is_array($data) ? $data : [];
    }

    public function save(array $styles)
    {
        $fs = new Filesystem();
        $fs->dumpFile($this->file, Yaml::dump($styles));
    }
}
