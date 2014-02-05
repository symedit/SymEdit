<?php

namespace SymEdit\Bundle\StylizerBundle\Loader;

interface LoaderInterface
{
    public function loadStyleData(ConfigData $configData);
}