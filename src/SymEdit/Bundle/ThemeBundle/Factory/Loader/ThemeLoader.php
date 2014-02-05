<?php

namespace SymEdit\Bundle\ThemeBundle\Factory\Loader;

use Assetic\Factory\Loader\FormulaLoaderInterface;
use Assetic\Factory\Resource\ResourceInterface;
use SymEdit\Bundle\ThemeBundle\Factory\Resource\ThemeResource;

class ThemeLoader implements FormulaLoaderInterface
{
    public function load(ResourceInterface $resource)
    {
        return $resource instanceof ThemeResource ? $resource->getContent() : array();
    }
}