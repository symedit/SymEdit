<?php

namespace SymEdit\Bundle\WidgetBundle\Renderer;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;

interface WidgetRendererInterface
{
    public function render(WidgetInterface $widget);
}