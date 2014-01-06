<?php

namespace SymEdit\Bundle\WidgetBundle\Widget;

use Doctrine\Common\Persistence\ObjectManager;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetAreaInterface;
use SymEdit\Bundle\WidgetBundle\Widget\WidgetRegistry;

class WidgetManager
{
    private $widgetRepository;
    private $widgetAreaRepository;
    private $widgetClass;
    private $widgetAreaClass;
    private $registry;
    private $om;

    public function __construct($widgetClass, $widgetAreaClass, WidgetRegistry $registry, ObjectManager $om)
    {
        $this->widgetClass = $widgetClass;
        $this->widgetAreaClass = $widgetAreaClass;

        $this->om = $om;
        $this->registry = $registry;

        // This will be injected directly eventually to use ODM / ORM whatever
        $this->widgetRepository = $om->getRepository($this->widgetClass);
        $this->widgetAreaRepository = $om->getRepository($this->widgetAreaClass);
    }

    /**
     * @return \SymEdit\Bundle\WidgetBundle\Model\WidgetAreaInterface
     */
    public function getWidgetAreas()
    {
        return $this->widgetAreaRepository->findAll();
    }

    /**
     * @param  string                                                     $area
     * @return \SymEdit\Bundle\WidgetBundle\Model\WidgetAreaInterface $widgetArea
     * @throws \Exception
     */
    public function getWidgetArea($area)
    {
        $widgetArea = $this->widgetAreaRepository->findOneBy(array(
            'area' => $area,
        ));

        if ($widgetArea === null) {
            throw new \Exception(sprintf('Could not find widget area "%s".', $area));
        }

        return $widgetArea;
    }

    public function saveWidgetArea(WidgetAreaInterface $area)
    {
        $this->om->persist($area);
        $this->om->flush($area);
    }

    /**
     * @return WidgetAreaInterface
     */
    public function createWidgetArea()
    {
        $class = $this->getWidgetAreaClass();

        return new $class();
    }

    public function getWidgetAreaClass()
    {
        return $this->widgetAreaClass;
    }

    /**
     * @return WidgetInterface
     */
    public function getWidgets()
    {
        return $this->widgetRepository->findAll();
    }

    public function saveWidget(WidgetInterface $widget)
    {
        $this->om->persist($widget);
        $this->om->flush($widget);
    }

    public function deleteWidget(WidgetInterface $widget)
    {
        $this->om->remove($widget);
        $this->om->flush($widget);
    }

    /**
     * @param  type            $id
     * @return WidgetInterface
     */
    public function findWidget($id)
    {
        return $this->widgetRepository->find($id);
    }

    /**
     * @param  array           $conditions
     * @return WidgetInterface
     * @throws \Exception
     */
    public function getWidgetBy(array $conditions)
    {
        return $this->widgetRepository->findOneBy($conditions);
    }

    /**
     * @return WidgetInterface
     */
    public function createWidget($strategyName = null)
    {
        $class = $this->getWidgetClass();
        $widget = new $class();

        if ($strategyName !== null) {
            $widget->setStrategyName($strategyName);
            $this->registry->init($widget);
        }

        return $widget;
    }

    public function getWidgetClass()
    {
        return $this->widgetClass;
    }
}
