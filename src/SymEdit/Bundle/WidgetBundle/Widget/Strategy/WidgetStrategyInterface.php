<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Templating\EngineInterface;

interface WidgetStrategyInterface
{
    /**
     * Get widget unique name
     */
    public function getName();

    /**
     * Get description of the widget
     */
    public function getDescription();

    /**
     * @param FormBuilderInterface $builder
     */
    public function buildForm(FormBuilderInterface $builder);

    /**
     * Executes the strategy
     *
     * @param WidgetInterface $widget The widget to be rendered
     */
    public function execute(WidgetInterface $widget);

    /**
     * @param WidgetInterface $widget
     */
    public function setDefaultOptions(WidgetInterface $widget);

    /**
     * @return EngineInterface
     */
    public function getTemplating();

    /**
     * @param EngineInterface $templating
     */
    public function setTemplating(EngineInterface $templating);

    /**
     * @param string $name       Template name
     * @param array  $parameters Template parameters
     */
    public function render($name, array $parameters = array());
}
