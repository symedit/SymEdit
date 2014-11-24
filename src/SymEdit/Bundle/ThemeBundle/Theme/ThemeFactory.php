<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Theme;

use InvalidArgumentException;
use SymEdit\Bundle\ThemeBundle\Model\ThemeInterface;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;

class ThemeFactory implements ThemeFactoryInterface
{
    protected $loader;
    protected $configuration;
    protected $themeDir;
    protected $publicDir;
    protected $model;
    protected $cacheDir;
    protected $processor;

    public function __construct(LoaderInterface $loader, ConfigurationInterface $configuration, $themeDir, $publicDir, $model, $cacheDir)
    {
        $this->loader = $loader;
        $this->configuration = $configuration;
        $this->themeDir = $themeDir;
        $this->publicDir = $publicDir;
        $this->model = $model;
        $this->processor = new Processor();
        $this->cacheDir = $cacheDir;
    }

    protected function loadTheme($name)
    {
        return $this->loadThemeData($name);
    }

    protected function getConfigData($name)
    {
        $configs = array();
        $resources = array();

        while (true) {
            $configFile = $this->getThemeFile($name);
            $config = $this->loader->load($configFile);
            $configs[] = $config;
            $resources[] = new FileResource($configFile);

            if (!isset($config['parent'])) {
                break;
            }

            $name = $config['parent'];
        }

        return array(array_reverse($configs), $resources);
    }

    /**
     * @return ThemeInterface
     */
    protected function loadThemeData($name)
    {
        $cachePath = sprintf('%s/theme_config/%s.php', $this->cacheDir, $name);
        $themeCache = new ConfigCache($cachePath, true);

        if (!$themeCache->isFresh()) {
            $this->buildCache($themeCache, $name);
        }

        return unserialize(file_get_contents($themeCache));
    }

    protected function getThemeFile($name)
    {
        return sprintf('%s/theme.yml', $name);
    }

    protected function buildCache(ConfigCache $cache, $name)
    {
        list($configs, $resources) = $this->getConfigData($name);
        $themeData = $this->processor->processConfiguration($this->configuration, $configs);

        if (isset($themeData['parent'])) {
            $themeData['parent'] = $this->loadTheme($themeData['parent']);
        }

        $cache->write(serialize($this->createTheme($themeData)), $resources);
    }

    /**
     * @return ThemeInterface Blank model
     */
    protected function createModel()
    {
        $theme = new $this->model;

        if (!$theme instanceof ThemeInterface) {
            throw new InvalidArgumentException('Theme model must implement ThemeInterface');
        }

        return $theme;
    }

    protected function createTheme($data)
    {
        $theme = $this->createModel();

        $theme->setName($data['name']);
        $theme->setDescription($data['description']);
        $theme->setStylesheets($data['stylesheets']);
        $theme->setJavascripts($data['javascripts']);
        $theme->setDirectory($this->themeDir);
        $theme->setPublicDirectory($this->publicDir);

        if (isset($data['parent'])) {
            $theme->setParentTheme($data['parent']);
        }

        return $theme;
    }

    /**
     * Get a Theme
     *
     * @param  string         $name
     * @return ThemeInterface
     */
    public function getTheme($name)
    {
        return $this->loadTheme($name);
    }
}
