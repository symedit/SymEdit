<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Twig\Extension;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Renderer\WidgetAreaRendererInterface;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;

class WidgetExtension extends \Twig_Extension
{
    protected $widgetRepository;
    protected $widgetAreaRepository;
    protected $widgetAreaRenderer;
    protected $handler;
    protected $esiStrategy;

    public function __construct(
        RepositoryInterface $widgetRepository,
        RepositoryInterface $widgetAreaRepository,
        WidgetAreaRendererInterface $widgetAreaRenderer,
        FragmentHandler $handler,
        $esiStrategy
    ) {
        $this->widgetRepository = $widgetRepository;
        $this->widgetAreaRepository = $widgetAreaRepository;
        $this->widgetAreaRenderer = $widgetAreaRenderer;
        $this->handler = $handler;
        $this->esiStrategy = $esiStrategy;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('symedit_widget_area_render', [$this, 'renderWidgetArea'], ['needs_context' => true, 'is_safe' => ['html']]),
            new \Twig_SimpleFunction('symedit_widget_render', [$this, 'renderWidget'], ['needs_context' => true, 'is_safe' => ['html']]),
        ];
    }

    public function renderWidgetArea($context, $area, $template = null)
    {
        $widgetArea = $this->widgetAreaRepository->findOneBy([
            'area' => $area,
        ]);

        if ($widgetArea === null) {
            return '';
        }

        return $this->widgetAreaRenderer->render($widgetArea, $template);
    }

    public function renderWidget($context, WidgetInterface $widget)
    {
        $controller = new ControllerReference(
            'symedit.controller.widget:renderAction',
            $this->getControllerAttributes($widget, $context)
        );

        return $this->handler->render($controller, $this->esiStrategy);
    }

    protected function getControllerAttributes(WidgetInterface $widget, $context)
    {
        return [
            'id' => $widget->getId(),
        ];
    }

    public function getName()
    {
        return 'symedit_widget';
    }
}
