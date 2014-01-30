<?php

namespace SymEdit\Bridge\Widget\Matcher\Voter;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\WidgetBundle\Matcher\Voter\StringPathVoter;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Get the current page from the Request and check to see if
 * it matches any of the paths.
 */
class CurrentPageVoter extends StringPathVoter
{
    protected $request;

    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function isVisible(WidgetInterface $widget)
    {
        if ($this->getRequest() === null || !$this->getRequest()->attributes->has('_page')) {
            return false;
        }

        /* @var $page PageInterface */
        $page = $this->getRequest()->attributes->get('_page');

        return $this->checkAssociation($widget, $page->getPath()) ||
               $this->checkAssociation($widget, $page->getId());
    }
}