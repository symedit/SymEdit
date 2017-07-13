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

use SymEdit\Bundle\CoreBundle\Iterator\PageIterator;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListChildrenStrategy extends PageAwareAbstractWidgetStrategy
{
    public function execute(WidgetInterface $widget, PageInterface $page = null)
    {
        /*
         * Don't render without a current page
         */
        if ($page === null) {
            return false;
        }

        return $this->render($widget, [
            'page' => $page,
            'children' => new PageIterator($page),
        ]);
    }

    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => '@SymEdit/Widget/list-children.html.twig',
        ]);
    }

    public function getName()
    {
        return 'list_children';
    }

    public function getDescription()
    {
        return 'core.list_children';
    }
}
