<?php

namespace SymEdit\Bundle\CoreBundle\Widget\Strategy;

use SymEdit\Bundle\CoreBundle\Iterator\PageIterator;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;

class ListChildrenStrategy extends AbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        /**
         * Don't render without a current page
         */
        if ($page === null) {
            return false;
        }

        return $this->render('@SymEdit/Widget/list-children.html.twig', array(
            'page' => $page,
            'children' => new PageIterator($page),
        ));
    }

    public function getName()
    {
        return 'list_children';
    }

    public function getDescription()
    {
        return 'List Children';
    }
}
