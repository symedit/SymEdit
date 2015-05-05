<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Storage;

use SymEdit\Bundle\SettingsBundle\Model\SettingsInterface;
use Symfony\Component\Yaml\Yaml;

class YamlConfigStorage implements SettingStorageInterface
{
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function load()
    {
        if (is_file($this->file) && is_readable($this->file)) {
            $result = Yaml::parse(file_get_contents($this->file));

            return is_array($result) ? $result : array();
        }

        return array();
    }

    public function save(SettingsInterface $settings)
    {
        file_put_contents($this->file, Yaml::dump($settings->all()));
    }
}
