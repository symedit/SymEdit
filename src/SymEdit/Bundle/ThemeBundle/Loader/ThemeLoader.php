<?php

namespace SymEdit\Bundle\ThemeBundle\Loader;

use SymEdit\Bundle\ThemeBundle\Model\Theme;
use Symfony\Component\Yaml\Yaml;

class ThemeLoader
{
    protected $themeDirectory;
    protected $publicDirectory;
    protected $themes = array();

    public function __construct($themeDirectory, $publicDirectory)
    {
        $this->themeDirectory = $themeDirectory;
        $this->publicDirectory = $publicDirectory;
    }

    public function getTheme($name)
    {
        if (!array_key_exists($name, $this->themes)) {
            $this->themes[$name] = $this->loadTheme($name);
        }

        return $this->themes[$name];
    }

    protected function loadTheme($name)
    {
        $theme = new Theme();
        $theme->setName($name);
        $theme->setThemeDirectory($this->getThemeDirectory($name));
        $theme->setPublicDirectory($this->getPublicDirectory($name));

        $configFile = $this->getThemeDirectory($name).'/theme.yml';
        $config = Yaml::parse(file_get_contents($configFile));

        if (isset($config['name'])) {
            if ($config['name'] !== $name) {
                throw new \Exception(sprintf('Requested theme %s does not match theme config "%s"', $name, $config['name']));
            }
        }

        if (isset($config['title'])) {
            $theme->setTitle($config['title']);
        }

        if (isset($config['stylesheets'])) {
            $theme->setStylesheets($this->prepareAssets($config['stylesheets'], $name));
        }

        if (isset($config['javascripts'])) {
            $theme->setJavascripts($this->prepareAssets($config['javascripts'], $name));
        }

        return $theme;
    }

    protected function prepareAssets(array $assets, $name)
    {
        return array_map(function($asset) use ($name) {
            return $this->prepareAsset($asset, $name);
        }, $assets);
    }

    protected function prepareAsset($asset, $name)
    {
        if ($asset[0] === '@' || $asset[0] === '/') {
            return $asset;
        }

        return $this->getThemeDirectory($name) . '/' . $asset;
    }

    protected function getThemeDirectory($name = null)
    {
        $directory = $this->themeDirectory;

        if ($name !== null) {
            $directory .= '/'.$name;
        }

        return $directory;
    }

    protected function getPublicDirectory($name = null)
    {
        $directory = $this->publicDirectory;

        if ($name !== null) {
            $directory .= '/'.$name;
        }

        return $directory;
    }
}