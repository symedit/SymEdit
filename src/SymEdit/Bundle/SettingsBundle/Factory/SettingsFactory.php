<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Factory;

use Doctrine\Common\Cache\Cache;
use SymEdit\Bundle\SettingsBundle\Loader\SettingsConfiguration;
use SymEdit\Bundle\SettingsBundle\Model\Settings;
use SymEdit\Bundle\SettingsBundle\Model\SettingsConfig;
use SymEdit\Bundle\SettingsBundle\Model\SettingsConfigInterface;
use SymEdit\Bundle\SettingsBundle\Storage\SettingStorageInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\LoaderInterface;

class SettingsFactory
{
    protected $loader;
    protected $storage;
    protected $files;
    protected $cache;
    protected $debug;

    public function __construct(LoaderInterface $loader, SettingStorageInterface $storage, Cache $cache, array $files, $debug)
    {
        $this->loader = $loader;
        $this->storage = $storage;
        $this->cache = $cache;
        $this->files = $files;
        $this->debug = $debug;
    }

    /**
     * @return SettingsConfigInterface
     */
    public function getSettingsConfig()
    {
        if (!$this->cache->contains('settings_config')) {
            $config = $this->loadConfigData();
        } else {
            $config = $this->cache->fetch('settings_config');
        }

        if (!$this->debug) {
            $this->cache->save('settings_config', $config);
        }

        return new SettingsConfig($config);
    }

    protected function loadConfigData()
    {
        foreach ($this->files as $file) {
            $configs[] = $this->loader->load($file);
        }

        $processor = new Processor();
        $configuration = new SettingsConfiguration();

        return $processor->processConfiguration($configuration, $configs);
    }

    public function getSettings()
    {
        if (!$this->cache->contains('settings')) {
            $settings = array_replace_recursive(
                $this->getSettingsConfig()->getDefaultValues(),
                $this->storage->load()
            );
        } else {
            $settings = $this->cache->fetch('settings');
        }

        if (!$this->debug) {
            $this->cache->save('settings', $settings);
        }

        return new Settings($settings);
    }
}
