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
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Widget\WidgetRegistry;
use Symfony\Component\HttpFoundation\Request;

class WidgetController extends ResourceController
{
    public function indexAction(Request $request)
    {
        $areas = $this->get('symedit.repository.widget_area')->findAll();

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Widget/index.html.twig')
            ->setData(array(
                'areas' => $areas,
                'registry' => $this->getRegistry(),
            ));

        return $this->handleView($view);
    }

    public function getForm($resource = null)
    {
        $type = $this->getConfiguration()->getFormType();

        if ($this->getConfiguration()->isApiRequest()) {
            return $this->container->get('form.factory')->createNamed('', $type, $resource, array(
                'csrf_protection' => false,
                'strategy' => $this->getStrategy($resource),
            ));
        }

        return $this->createForm($type, $resource, array(
            'strategy' => $this->getStrategy($resource),
        ));
    }

    public function chooseAction()
    {
        /* @var $registry WidgetRegistry */
        $registry = $this->get('symedit_widget.widget.registry');
        $strategies = $registry->getStrategies();

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Widget/choose.html.twig')
            ->setTemplateVar('strategies')
            ->setData(array(
                'strategies' => $strategies,
            ));

        return $this->handleView($view);
    }

    public function createNew()
    {
        $strategyName = $this->getRequest()->get('strategyName');

        try {
            $widget = $this->getRepository()->createNew($strategyName);
        } catch (\Exception $e) {
            throw $this->createNotFoundException(sprintf('Widget with strategy name "%s" does not exist', $strategyName));
        }

        return $widget;
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
}
