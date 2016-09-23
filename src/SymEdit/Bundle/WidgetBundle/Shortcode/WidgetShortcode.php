<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Shortcode;

use SymEdit\Bundle\ShortcodeBundle\Shortcode\AbstractShortcode;
use SymEdit\Bundle\WidgetBundle\Factory\WidgetFactoryInterface;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;

class WidgetShortcode extends AbstractShortcode
{
    private $factory;
    private $handler;

    public function __construct(WidgetFactoryInterface $factory, FragmentHandler $handler)
    {
        $this->factory = $factory;
        $this->handler = $handler;
    }

    public function renderShortcode($match, array $attr, $content)
    {
        if (!isset($attr['strategy'])) {
            return 'Missing "strategy" attribute.';
        }

        $strategyName = $attr['strategy'];
        unset($attr['strategy']);

        $controller = new ControllerReference(
            'symedit.controller.widget:createAndRenderAction',
            [
                'strategyName' => $strategyName,
                'options' => $attr,
            ]
        );

        return $this->handler->render($controller);
    }

    public function getName()
    {
        return 'widget';
    }
}
