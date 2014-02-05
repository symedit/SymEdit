<?php

namespace SymEdit\Bundle\ThemeBundle\Theme;

class ThemeManager
{
    protected $loader;
    protected $themes = array();

    public function __construct(ThemeLoader $loader)
    {
        $this->loader = $loader;
    }

    public function getLoader()
    {
        return $this->loader;
    }

    public function setLoader(ThemeLoader $loader)
    {
        $this->loader = $loader;

        return $this;
    }

    public function getTheme($name)
    {
        if (!array_key_exists($name, $this->themes)) {
            $this->themes[$name] = $this->loader->load($name);
        }

        return $this->themes[$name];
    }
}