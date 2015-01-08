<?php

namespace SymEdit\Bundle\WidgetBundle\Renderer;

use SymEdit\Bundle\WidgetBundle\Matcher\WidgetMatcherInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetAreaInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Templating\TemplateReference;

class WidgetAreaRenderer implements WidgetAreaRendererInterface
{
    protected $twig;
    protected $widgetRenderer;
    protected $matcher;

    public function __construct(\Twig_Environment $twig, WidgetRendererInterface $widgetRenderer, WidgetMatcherInterface $matcher)
    {
        $this->twig = $twig;
        $this->widgetRenderer = $widgetRenderer;
        $this->matcher = $matcher;
    }

    public function render(WidgetAreaInterface $widgetArea)
    {
        $widgets = array();

        foreach ($widgetArea->getWidgets() as $widget) {
            if (!$this->matcher->isVisible($widget)) {
                continue;
            }

            if (($widgetData = $this->executeWidget($widget)) === false) {
                continue;
            }

            $widgets[] = $widgetData;
        }

        return $this->renderTemplate($widgetArea, $widgets);
    }

    protected function executeWidget(WidgetInterface $widget)
    {
        return $this->widgetRenderer->render($widget);
    }

    protected function renderTemplate(WidgetAreaInterface $widgetArea, array $widgets)
    {
        $templateName = sprintf('@SymEdit/WidgetArea/%s.html.twig', $widgetArea->getArea());
        $template = new TemplateReference($templateName);

        if (!$this->templateExists($template)) {
            $template->set('name', '@SymEdit/WidgetArea/default.html.twig');
        }

        return $this->twig->render($template, array(
            'widgetArea' => $widgetArea,
            'widgets' => $widgets,
            'area' => $widgetArea->getArea(),
        ));
    }

    private function templateExists($template)
    {
        $loader = $this->twig->getLoader();

        if ($loader instanceof \Twig_ExistsLoaderInterface) {
            return $loader->exists($template);
        }

        return false;
    }
}
