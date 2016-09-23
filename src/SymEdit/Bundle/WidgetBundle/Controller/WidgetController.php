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

use FOS\RestBundle\View\View;
use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use SymEdit\Bundle\WidgetBundle\Event\Events;
use SymEdit\Bundle\WidgetBundle\Event\WidgetEvent;
use SymEdit\Bundle\WidgetBundle\Factory\WidgetFactoryInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Renderer\WidgetRendererInterface;
use SymEdit\Bundle\WidgetBundle\Widget\WidgetRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WidgetController extends ResourceController
{
    public function renderAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $widget = $this->findOr404($configuration);

        return $this->renderWidget($request, $widget);
    }

    public function createAndRenderAction(Request $request, $strategyName, array $options = [])
    {
        try {
            $widget = $this->getFactory()->createFromStrategy($strategyName, $options);
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }

        return $this->renderWidget($request, $widget);
    }

    protected function renderWidget(Request $request, WidgetInterface $widget)
    {
        $strategy = $this->getStrategy($widget);

        // Prepare pre render event
        $preEvent = new WidgetEvent($widget, $strategy, new Response());
        $this->get('event_dispatcher')->dispatch(Events::WIDGET_PRE_RENDER, $preEvent);

        // Setup response
        $response = $preEvent->getResponse();

        // Set Response content if not cached
        if (!$response->isNotModified($request)) {
            $content = $this->getWidgetRenderer()->render($widget);
            $response->setContent($content);
        }

        // Dispatch post render event
        $postEvent = new WidgetEvent($widget, $strategy, $response);
        $this->get('event_dispatcher')->dispatch(Events::WIDGET_POST_RENDER, $postEvent);

        return $response;
    }

    /**
     * @param WidgetInterface $widget
     *
     * @return Response
     */
    protected function getWidgetResponse(WidgetInterface $widget)
    {
        $response = new Response();
        $response->setCache($this->getStrategy($widget)->getCacheOptions($widget));

        return $response;
    }

    public function indexAction(Request $request)
    {
        $areas = $this->get('symedit.repository.widget_area')->findAll();
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $view = View::create()
            ->setTemplate('@SymEdit/Admin/Widget/index.html.twig')
            ->setData([
                'areas' => $areas,
                'registry' => $this->getRegistry(),
            ]);

        return $this->viewHandler->handle($configuration, $view);
    }

    public function chooseAction(Request $request)
    {
        /* @var $registry WidgetRegistry */
        $registry = $this->get('symedit_widget.widget.registry');
        $strategies = $registry->getStrategies();
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $view = View::create()
            ->setTemplate('@SymEdit/Admin/Widget/choose.html.twig')
            ->setTemplateVar('strategies')
            ->setData([
                'strategies' => $strategies,
            ]);

        return $this->viewHandler->handle($configuration, $view);
    }

    protected function getStrategy(WidgetInterface $widget)
    {
        return $this->getRegistry()->getStrategy($widget->getStrategyName());
    }

    /**
     * @return WidgetRegistry
     */
    protected function getRegistry()
    {
        return $this->get('symedit_widget.widget.registry');
    }

    /**
     * @return WidgetFactoryInterface
     */
    protected function getFactory()
    {
        return $this->get('symedit.factory.widget');
    }

    /**
     * @return WidgetRendererInterface Get widget renderer
     */
    protected function getWidgetRenderer()
    {
        return $this->get('symedit_widget.renderer.widget.default');
    }
}
