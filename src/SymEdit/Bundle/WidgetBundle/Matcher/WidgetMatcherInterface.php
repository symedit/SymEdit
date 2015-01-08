<?php

namespace SymEdit\Bundle\WidgetBundle\Matcher;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

interface WidgetMatcherInterface
{
    public function addVoter(VoterInterface $voter);
    public function isVisible(WidgetInterface $widget);
}
