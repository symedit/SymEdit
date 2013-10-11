<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;

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
            'children' => $page->getChildren(),
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