<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Event;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\Strategy\WidgetStrategyInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;

class WidgetEvent extends Event
{
    private $widget;
    private $strategy;
    private $response;

    public function __construct(WidgetInterface $widget, WidgetStrategyInterface $strategy, Response $response)
    {
        $this->widget = $widget;
        $this->strategy = $strategy;
        $this->response = $response;
    }

    /**
     * @return WidgetInterface
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @return WidgetStrategyInterface
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }
}
