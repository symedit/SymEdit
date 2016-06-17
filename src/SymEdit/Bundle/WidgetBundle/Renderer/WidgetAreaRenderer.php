<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Renderer;

use SymEdit\Bundle\WidgetBundle\Matcher\WidgetMatcherInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetAreaInterface;
use Symfony\Component\Templating\TemplateReference;

class WidgetAreaRenderer implements WidgetAreaRendererInterface
{
    protected $twig;
    protected $widgetRenderer;
    protected $matcher;

    public function __construct(\Twig_Environment $twig, WidgetMatcherInterface $matcher)
    {
        $this->twig = $twig;
        $this->matcher = $matcher;
    }

    public function render(WidgetAreaInterface $widgetArea, $template = null)
    {
        $widgets = $this->matcher->getVisible($widgetArea->getWidgets());

        return $this->renderTemplate($widgetArea, $widgets, $template);
    }

    protected function renderTemplate(WidgetAreaInterface $widgetArea, array $widgets, $template = null)
    {
        $templateName = $template === null ? sprintf('@SymEdit/WidgetArea/%s.html.twig', $widgetArea->getArea()) : $template;
        $template = new TemplateReference($templateName);

        if (!$this->templateExists($template)) {
            $template->set('name', '@SymEdit/WidgetArea/default.html.twig');
        }

        return $this->twig->render($template, [
            'widgetArea' => $widgetArea,
            'widgets' => $widgets,
            'area' => $widgetArea->getArea(),
        ]);
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
