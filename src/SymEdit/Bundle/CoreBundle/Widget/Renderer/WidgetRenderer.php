<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Widget\Renderer;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Renderer\WidgetRenderer as BaseRenderer;

class WidgetRenderer extends BaseRenderer
{
    protected $page;

    public function setCurrentPage(PageInterface $page = null)
    {
        $this->page = $page;
    }

    public function render(WidgetInterface $widget)
    {
        return $this->getStrategy($widget)->execute($widget, $this->page);
    }
}
