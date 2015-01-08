<?php

namespace SymEdit\Bundle\WidgetBundle\Renderer;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;

class WidgetRenderer implements WidgetRendererInterface
{
    public function render(WidgetInterface $widget)
    {
        $content = $widget->getStrategy()->execute($widget);

        if ($content === false) {
            return false;
        }

        return array(
            'id' => $widget->getId(),
            'name' => $widget->getName(),
            'title' => $widget->getTitle(),
            'content' => $content,
        );
    }
}
