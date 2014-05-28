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

use SymEdit\Bundle\SettingsBundle\Exception\InvalidSettingException;
use SymEdit\Bundle\SettingsBundle\Loader\ConfigData;
use SymEdit\Bundle\SettingsBundle\Loader\SettingsConfiguration;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Yaml\Yaml;

class Settings implements \ArrayAccess
{
    private $loader;
    private $files;
    private $settings;
    private $rootDir;
    private $cacheDir;
    private $debug;
    private $configData;

    public function __construct(LoaderInterface $loader, array $files, $rootDir, $cacheDir, $debug)
    {
        $this->loader = $loader;
        $this->files = $files;
        $this->rootDir = $rootDir;
        $this->cacheDir = $cacheDir;
        $this->debug = $debug;
    }

    /**
     * @return ConfigData
     */
    public function getConfigData()
    {
        if ($this->configData === null) {
            $this->configData = $this->loadConfigData();
        }

        return $this->configData;
    }

    private function loadConfigData()
    {
        $cachePath = $this->cacheDir . '/settings_config.php';
        $configCache = new ConfigCache($cachePath, $this->debug);

        if (!$configCache->isFresh()) {
            $resources = array();
            $configs = array();

            foreach ($this->files as $file) {
                $configs[] = $this->loader->load($file);
                $resources[] = new FileResource($file);
            }

            $processor = new Processor();
            $configuration = new SettingsConfiguration();

            $config = $processor->processConfiguration($configuration, $configs);

            $configCache->write(sprintf('<?php return %s;', var_export($config, true)), $resources);
        }

        return require $cachePath;
    }

    public function getDefaultValues()
    {
        $configData = $this->getConfigData();
        $settingsData = array();

        foreach ($configData as $groupName => $groupData) {
            $settingsData[$groupName] = array();

            foreach ($groupData['settings'] as $settingName => $settingData) {
                $settingsData[$groupName][$settingName] = array_key_exists('default', $settingData) ? $settingData['default'] : null;
            }
        }

        return $settingsData;
    }

    private function getMergedSettings()
    {
        $cache = new ConfigCache($this->cacheDir . '/settings.php', $this->debug);

        if (!$cache->isFresh()) {

            $file = sprintf('%s/config/settings.yml', $this->rootDir);
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
        file_put_contents($this->rootDir . '/config/settings.yml', Yaml::dump($this->getSettings()));

        // List of cache files to delete
        $cacheFiles = array('settings_config.php', 'settings.php');

        // Remove cache file
        foreach ($cacheFiles as $file) {
            if (file_exists($fileName = $this->cacheDir . '/' . $file)) {
                unlink($fileName);
            }
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

    public function getDefault($offset, $default = null)
    {
        return $this->has($offset) ? $this->get($offset) : $default;
    }

    public function offsetExists($offset)
    {
        list($group, $setting) = $this->parseOffset($offset);

        $settings = $this->getSettings();

        return array_key_exists($group, $settings) &&
                ($setting === null || array_key_exists($setting, $settings[$group]));
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
