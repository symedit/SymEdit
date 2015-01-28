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
use SymEdit\Bundle\WidgetBundle\Twig\TokenParser;

class WidgetExtension extends \Twig_Extension
{
    protected $widgetRepository;
    protected $container;
    protected $widgetRenderer;
    protected $esiStrategy;

    public function __construct(RepositoryInterface $widgetRepository, \Symfony\Component\DependencyInjection\ContainerInterface $container, $esiStrategy)
    {
        $this->esiStrategy = $esiStrategy;
        $this->widgetRepository = $widgetRepository;
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('symedit_widget_get', array($this, 'getWidget')),
        );
    }

    public function getWidget($name)
    {
        $widget = $this->widgetRepository->findOneBy(array(
            'name' => $name,
        ));

        if (!$widget) {
            return;
        }

        return $this->getWidgetRenderer()->render($widget);
    }

    protected function getWidgetRenderer()
    {
        if ($this->widgetRenderer === null) {
            $this->widgetRenderer = $this->container->get('symedit_widget.renderer.widget.default');
        }

        return $this->widgetRenderer;
    }

    public function getTokenParsers()
    {
        return array(
            new TokenParser\WidgetAreaTokenParser($this->esiStrategy),
        );
    }

    public function getName()
    {
        return 'symedit_widget';
    }
}
