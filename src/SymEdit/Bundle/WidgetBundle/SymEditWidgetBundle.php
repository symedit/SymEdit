<?php

namespace SymEdit\Bundle\WidgetBundle;

use SymEdit\Bundle\WidgetBundle\DependencyInjection\SymEditWidgetExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SymEditWidgetBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension()
    {
        return new SymEditWidgetExtension();
    }
}
