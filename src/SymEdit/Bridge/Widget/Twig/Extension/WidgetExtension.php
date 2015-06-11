<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bridge\Widget\Twig\Extension;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Twig\Extension\WidgetExtension as BaseExtension;

/**
 * Pass in a different TokenParser for SymEdit specific widgets.
 */
class WidgetExtension extends BaseExtension
{
    protected function getControllerAttributes(WidgetInterface $widget, $context)
    {
        return array(
            'id' => $widget->getId(),
            '_page_id' => $context['Page']->getId(),
        );
    }
}
