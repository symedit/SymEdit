<?php

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Templating\EngineInterface;

abstract class AbstractWidgetStrategy implements WidgetStrategyInterface
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(WidgetInterface $widget)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    /**
     * {@inheritDoc}
     */
    public function render($name, array $parameters = array())
    {
        return $this->templating->render($name, $parameters);
    }
}
