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

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Templating\EngineInterface;

abstract class AbstractWidgetStrategy implements WidgetStrategyInterface
{
    /**
     * @var EngineInterface
     */
    protected $templating;

    public function getDefaultOptions(OptionsResolver $resolver)
    {
    }

    public function buildForm(FormBuilderInterface $builder)
    {
    }

    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @return EngineInterface
     */
    public function getTemplating()
    {
        return $this->templating;
    }

    public function render($name, array $parameters = array())
    {
        return $this->templating->render($name, $parameters);
    }
}
