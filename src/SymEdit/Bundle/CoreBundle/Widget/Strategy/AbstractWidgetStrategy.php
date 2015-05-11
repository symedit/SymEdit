<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
    public function getDefaultOptions(OptionsResolver $resolver)
    {
    }

    public function getCacheOptions(WidgetInterface $widget)
    {
        return array(
            'public' => true,
            's_maxage' => 60,
        );
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
    public function render(WidgetInterface $widget, array $parameters = array())
    {
        return $this->templating->render($widget->getOption('template'), $parameters);
    }
}
