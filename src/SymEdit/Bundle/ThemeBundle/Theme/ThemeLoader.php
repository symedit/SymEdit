<?php

namespace SymEdit\Bundle\ThemeBundle\Theme;

use SymEdit\Bundle\ThemeBundle\Model\Theme;
use Symfony\Component\Yaml\Yaml;

class ThemeLoader
{
    protected $themeDir;
    protected $publicDir;

    public function __construct($themeDir, $publicDir)
    {
        $this->themeDir = $themeDir;
        $this->publicDir = $publicDir;
    }

    public function load($name)
    {
        $theme = new Theme();
        $theme->setName($name);
        $theme->setThemeDirectory($this->getThemeDirectory($name));
        $theme->setPublicDirectory($this->getPublicDirectory($name));

        $configFile = $this->getThemeDirectory($name).'/theme.yml';
        $config = Yaml::parse(file_get_contents($configFile));
        $config = $config['theme'];

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
        if ($asset[0] === '@' || $asset[0] === '/' || strpos($asset, 'bundles') === 0) {
            return $asset;
        }

        return $this->getThemeDirectory($name) . '/' . $asset;
    }

    protected function getThemeDirectory($name = null)
    {
        $directory = $this->themeDir;

        if ($name !== null) {
            $directory .= '/'.$name;
        }

        return $directory;
    }

    protected function getPublicDirectory($name = null)
    {
        $directory = $this->publicDir;

        if ($name !== null) {
            $directory .= '/'.$name;
        }

        return $directory;
    }
}