<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Widget\Matcher\Voter;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Matcher\Voter\StringPathVoter;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Get the current page from the Request and check to see if
 * it matches any of the paths.
 */
class CurrentPageVoter extends StringPathVoter
{
    protected $requestStack;

    public function setRequest(RequestStack $requestStack = null)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }

    public function isVisible(WidgetInterface $widget)
    {
        if ($this->getRequest() === null || !$this->getRequest()->attributes->has('_page')) {
            return false;
        }

        /* @var $page PageInterface */
        $page = $this->getRequest()->attributes->get('_page');

        return $this->checkAssociation($widget, $page->getPath()) ||
               ($page->getId() !== null && $this->checkAssociation($widget, $page->getId()));
    }
}
