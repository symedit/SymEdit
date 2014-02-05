<?php

namespace SymEdit\Bundle\StylizerBundle\Loader;

/**
 * Loads data from multiple loaders
 */
class LoaderChain implements LoaderInterface
{
    protected $loaders;

    public function __construct(array $loaders)
    {
        $this->loaders = $loaders;
    }

    public function loadStyleData(ConfigData $configData)
    {
        foreach($this->loaders as $loader) {
            $loader->loadStyleData($configData);
        }
    }
}