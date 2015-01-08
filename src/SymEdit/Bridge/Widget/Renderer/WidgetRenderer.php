<?php

namespace SymEdit\Bridge\Widget\Renderer;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Renderer\WidgetRenderer as BaseRenderer;

class WidgetRenderer extends BaseRenderer
{
    protected $page;

    public function setCurrentPage(PageInterface $page = null)
    {
        $this->page = $page;
    }

    public function render(WidgetInterface $widget)
    {
        $content = $widget->getStrategy()->execute($widget, $this->page);

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
