<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Controller;

use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use SymEdit\Bundle\WidgetBundle\Renderer\WidgetAreaRendererInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WidgetAreaController extends ResourceController
{
    public function renderAreaAction(Request $request, $area)
    {
        $response = $this->getResponse();

        if ($response->isNotModified($request)) {
            return $response;
        }

        $content = $this->getWidgetAreaRenderer()->render($this->getWidgetArea($area));

        return $response->setContent($content);
    }

    /**
     * @return Response
     */
    protected function getResponse()
    {
        return new Response();
    }

    protected function getWidgetArea($area)
    {
        if (!$widgetArea = $this->getRepository()->findOneByArea($area)) {
            throw new NotFoundHttpException(sprintf('Widget area "%s" does not exist', $area));
        }

        return $widgetArea;
    }

    /**
     * @return WidgetAreaRendererInterface
     */
    protected function getWidgetAreaRenderer()
    {
        return $this->get('symedit_widget.renderer.area.default');
    }
}
