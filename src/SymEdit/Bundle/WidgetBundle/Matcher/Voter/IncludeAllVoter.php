<?php

namespace SymEdit\Bundle\WidgetBundle\Matcher\Voter;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Model\Widget;

/**
 * If visibility is set to INCLUDE_ALL then it should
 * be rendered regardless
 */
class IncludeAllVoter implements VoterInterface
{
    public function isVisible(WidgetInterface $widget)
    {
        return $widget->getVisibility() === Widget::INCLUDE_ALL;
    }
}