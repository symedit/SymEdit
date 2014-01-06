<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Model;

use SymEdit\Bundle\SettingsBundle\Loader\LoaderInterface;
use SymEdit\Bundle\SettingsBundle\Loader\ConfigData;
use SymEdit\Bundle\SettingsBundle\Exception\InvalidSettingException;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Yaml\Yaml;

class Settings implements \ArrayAccess
{
    private $loader;
    private $configData;
    private $settings;
    private $root_dir;
    private $cache_dir;
    private $debug;

    public function __construct(LoaderInterface $loader, $root_dir, $cache_dir, $debug)
    {
        $this->loader = $loader;
        $this->root_dir = $root_dir;
        $this->cache_dir = $cache_dir;
        $this->debug = $debug;
    }

    /**
     * @return \SymEdit\Bundle\SettingsBundle\Loader\ConfigData
     */
    public function getConfigData()
    {
        if ($this->configData === null) {
            $this->configData = new ConfigData();
            $this->loader->loadSettingsData($this->configData);
        }

        return $this->configData;
    }

    public function getDefaultValues()
    {
        return $this->getConfigData()->flatten();
    }

    private function getMergedSettings()
    {
        $cache = new ConfigCache($this->cache_dir . '/settings.php', $this->debug);

        if (!$cache->isFresh()) {
            $file = sprintf('%s/config/settings.yml', $this->root_dir);
            $settings = is_file($file) && is_readable($file) ? Yaml::parse($file) : array();

            if (!is_array($settings)) {
                $settings = array();
            }

            $merged = array_replace_recursive($this->getDefaultValues(), $settings);
            $cache->write(sprintf('<?php return %s;', var_export($merged, true)));
        }

        return require $cache;
    }

    public function getSettings()
    {
        if ($this->settings === null) {
            $this->settings = $this->getMergedSettings();
        }

        return $this->settings;
    }

    public function save()
    {
        file_put_contents($this->root_dir . '/config/settings.yml', Yaml::dump($this->getSettings()));

        // Remove cache file
        if (file_exists($file = $this->cache_dir . '/settings.php')) {
            unlink($file);
        }

        // Warm up again
        $this->getMergedSettings();
    }

    public function has($offset)
    {
        return $this->offsetExists($offset);
    }

    public function get($offset)
    {
        return $this->offsetGet($offset);
    }

    public function offsetExists($offset)
    {
        list($group, $setting) = $this->parseOffset($offset);

        $settings = $this->getSettings();

        return isset($settings[$group]) && ($setting === null || isset($settings[$group][$setting]));
    }

    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new InvalidSettingException(sprintf('Setting "%s" does not exist.', $offset));
        }

        list($group, $setting) = $this->parseOffset($offset);

        $settings = $this->getSettings();

        return $setting === null ? $settings[$group] : $settings[$group][$setting];
    }

    public function offsetSet($offset, $value)
    {
        if (!$this->offsetExists($offset)) {
            throw new InvalidSettingException(sprintf('Cannot set setting "%s", it does not exist.', $offset));
        }

        list($group, $setting) = $this->parseOffset($offset);

        if ($setting === null) {
            $this->settings[$group] = $value;
        } else {
            $this->settings[$group][$setting] = $value;
        }
    }

    private function parseOffset($offset)
    {
        $group = $offset;
        $setting = null;

        if (strpos($offset, '.') !== false) {
            list($group, $setting) = explode('.', $offset);
        }

        return array($group, $setting);
    }

    public function offsetUnset($offset)
    {
        // TODO Do I need this?
        return;
    }

}