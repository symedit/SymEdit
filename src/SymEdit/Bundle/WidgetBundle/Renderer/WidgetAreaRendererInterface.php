<?php

namespace SymEdit\Bundle\WidgetBundle\Renderer;

use SymEdit\Bundle\WidgetBundle\Model\WidgetAreaInterface;

interface WidgetAreaRendererInterface
{
    public function render(WidgetAreaInterface $widgetArea);
}