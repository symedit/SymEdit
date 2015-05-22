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

class TemplateStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget)
    {
        try {
            $content = $this->render($widget);
        } catch (\Exception $e) {
            $content = sprintf('There was an error rendering your template: "%s"', $e->getMessage());
        }

        return $content;
    }

    public function getName()
    {
        return 'template';
    }

    public function getDescription()
    {
        return 'widget.template';
    }
}
