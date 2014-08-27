<?php

namespace SymEdit\Bundle\StylizerBundle\Model;

use SymEdit\Bundle\StylizerBundle\Loader\ConfigData;
use SymEdit\Bundle\StylizerBundle\Loader\LoaderInterface;
use SymEdit\Bundle\StylizerBundle\Storage\StorageInterface;

class StyleManager
{
    protected $loader;
    protected $storage;
    protected $configData;
    protected $styles;

    public function __construct(LoaderInterface $loader, StorageInterface $storage)
    {
        $this->loader = $loader;
        $this->storage = $storage;
    }

    /**
     * Get the config data
     *
     * @return ConfigData
     */
    public function getConfigData()
    {
        if ($this->configData === null) {
            $this->configData = new ConfigData();
            $this->loader->loadStyleData($this->configData);
        }

        return $this->configData;
    }

    public function getDefaultValues()
    {
        return $this->getConfigData()->getVariables();
    }

    public function getVariables()
    {
        return array_replace($this->getDefaultValues(), $this->storage->load());
    }

    public function getStyles()
    {
        if ($this->styles === null) {
            $this->styles = new Styles($this->getVariables());
        }

        return $this->styles;
    }

    public function saveStyles(Styles $styles)
    {
        $this->storage->save($styles->getVariables());
    }
}
