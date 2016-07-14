<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Twig\Extension;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Twig\Extension\WidgetExtension as BaseExtension;

/**
 * Pass in a different TokenParser for SymEdit specific widgets.
 */
class WidgetExtension extends BaseExtension
{
    /**
     * Override renderWidgetArea to use page display options to display
     * the widget area if no template is provided as a hardcoded override.
     */
    public function renderWidgetArea($context, $area, $template = null)
    {
        if ($template === null && $context['Page'] && $context['Page']->getId() !== null) {
            $displayOptions = $context['Page']->getDisplayOptions();

            $template = isset($displayOptions[$area]['template']) ? $displayOptions[$area]['template'] : null;
        }

        return parent::renderWidgetArea($context, $area, $template);
    }

    protected function getControllerAttributes(WidgetInterface $widget, $context)
    {
        return [
            'id' => $widget->getId(),
            '_page_id' => $context['Page']->getId(),
        ];
    }
}
