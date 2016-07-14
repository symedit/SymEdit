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

use SymEdit\Bundle\ThemeBundle\Model\ThemeInterface;
use SymEdit\Bundle\ThemeBundle\Theme\Exception\ThemeLoadingException;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\LoaderInterface;

class ThemeFactory implements ThemeFactoryInterface
{
    protected $loader;
    protected $configuration;
    protected $themeConfig;
    protected $processor;

    public function __construct(LoaderInterface $loader, ConfigurationInterface $configuration, array $themeConfig)
    {
        $this->loader = $loader;
        $this->configuration = $configuration;
        $this->themeConfig = $themeConfig;
    }

    protected function getConfigData($name)
    {
        $configs = [];

        while (true) {
            $configFile = $this->getThemeFile($name);
            $config = $this->loader->load($configFile);
            $configs[] = $config;

            if (!isset($config['parent'])) {
                break;
            }

            $name = $config['parent'];
        }

        return array_reverse($configs);
    }

    /**
     * @return ThemeInterface
     */
    public function getTheme($name)
    {
        $configs = $this->getConfigData($name);
        $themeData = $this->getProcessor()->processConfiguration($this->configuration, $configs);

        if ($themeData['name'] !== $name) {
            throw new ThemeLoadingException(
                sprintf('Theme name "%s" should match theme folder name "%s".', $themeData['name'], $name)
            );
        }

        if (isset($themeData['parent'])) {
            $themeData['parent'] = $this->getTheme($themeData['parent']);
        }

        return $this->createTheme($themeData);
    }

    protected function getThemeFile($name)
    {
        return sprintf('%s/theme.yml', $name);
    }

    /**
     * @return ThemeInterface Blank model
     */
    protected function createModel()
    {
        $theme = new $this->themeConfig['model']();

        if (!$theme instanceof ThemeInterface) {
            throw new ThemeLoadingException(sprintf('Theme model "%s" must implement ThemeInterface', get_class($theme)));
        }

        return $theme;
    }

    protected function createTheme($data)
    {
        $theme = $this->createModel();

        $theme->setName($data['name']);
        $theme->setTitle($data['title']);
        $theme->setDescription($data['description']);
        $theme->setStylesheets($data['stylesheets']);
        $theme->setJavascripts($data['javascripts']);
        $theme->setDirectory($this->themeConfig['theme_directory']);
        $theme->setPublicDirectory($this->themeConfig['public_directory']);

        if (isset($data['parent'])) {
            $theme->setParentTheme($data['parent']);
        }

        return $theme;
    }

    protected function getProcessor()
    {
        if ($this->processor === null) {
            $this->processor = new Processor();
        }

        return $this->processor;
    }
}
