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

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Loader\LoaderInterface;
use SymEdit\Bundle\ThemeBundle\Model\ThemeInterface;

class ThemeFactory implements ThemeFactoryInterface
{
    protected $loader;
    protected $configuration;
    protected $themeDir;
    protected $publicDir;
    protected $model;
    protected $processor;

    public function __construct(LoaderInterface $loader, ConfigurationInterface $configuration, $themeDir, $publicDir, $model)
    {
        $this->loader = $loader;
        $this->configuration = $configuration;
        $this->themeDir = $themeDir;
        $this->publicDir = $publicDir;
        $this->model = $model;
        $this->processor = new Processor();
    }

    /**
     * @TODO: Use symfony config cache here
     */
    protected function loadTheme($name)
    {
        $themeData = $this->loader->load($name.'/theme.yml');

        return $this->processor->processConfiguration($this->configuration, $themeData);
    }

    /**
     * @return ThemeInterface Blank model
     */
    protected function createModel()
    {
        $theme = new $this->model;

        if (!$theme instanceof ThemeInterface) {
            throw new \InvalidArgumentException('Theme model must implement ThemeInterface');
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

        return $theme;
    }

    /**
     * Get a Theme
     *
     * @param string $name
     * @return ThemeInterface
     */
    public function getTheme($name)
    {
        $themeData = $this->loadTheme($name);

        return $this->createTheme($themeData);
    }
}