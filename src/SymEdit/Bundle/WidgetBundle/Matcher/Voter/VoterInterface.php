<?php

namespace SymEdit\Bundle\WidgetBundle\Matcher\Voter;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;

interface VoterInterface
{
    public function isVisible(WidgetInterface $widget);
}