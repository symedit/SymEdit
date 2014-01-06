<?php

namespace SymEdit\Bundle\WidgetBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Templating\EngineInterface;

interface WidgetStrategyInterface
{
    public function getName();
    public function getDescription();

    /**
     * @param FormBuilderInterface $builder
     */
    public function buildForm(FormBuilderInterface $builder);

    /**
     * Executes the strategy
     *
     * @param WidgetInterface $widget The widget to be rendered
     * @param PageInterface $page $name If a page is currently active it will be passed
     */
    public function execute(WidgetInterface $widget, PageInterface $page = null);

    public function setDefaultOptions(WidgetInterface $widget);

    /**
     * @return EngineInterface
     */
    public function getTemplating();

    public function setTemplating(EngineInterface $templating);

    /**
     * @param string $name       Template name
     * @param array  $parameters Template parameters
     */
    public function render($name, array $parameters = array());
}
