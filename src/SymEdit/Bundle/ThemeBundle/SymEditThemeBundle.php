<?php

namespace SymEdit\Bundle\ThemeBundle;

use SymEdit\Bundle\ThemeBundle\DependencyInjection\SymEditThemeExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditThemeBundle extends Bundle
{
    public function getParent()
    {
        return 'AsseticBundle';
    }

    public function getContainerExtension()
    {
        return new SymEditThemeExtension();
    }
}
