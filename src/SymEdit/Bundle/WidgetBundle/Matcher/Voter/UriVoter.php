<?php

namespace SymEdit\Bundle\WidgetBundle\Matcher\Voter;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Test the URI of the Request against the associations
 */
class UriVoter extends StringPathVoter
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
        if ($this->getRequest() === null) {
            return false;
        }

        return $this->checkAssociation($widget, $this->getRequest()->getUri());
    }
}