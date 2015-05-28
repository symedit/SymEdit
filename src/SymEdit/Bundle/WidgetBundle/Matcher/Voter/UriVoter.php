<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Matcher\Voter;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Test the URI of the Request against the associations.
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

        return $this->checkValue($widget, trim($this->getRequest()->getUri(), '/'));
    }

    protected function cleanAssociation($assoc)
    {
        return trim($assoc, '/');
    }
}
