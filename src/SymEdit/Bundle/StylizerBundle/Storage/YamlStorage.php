<?php

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
        $data = is_file($this->file) && is_readable($this->file) ? Yaml::parse($this->file) : array();

        return is_array($data) ? $data : array();
    }

    public function save(array $styles)
    {
        $fs = new Filesystem();
        $fs->dumpFile($this->file, Yaml::dump($styles));
    }
}
