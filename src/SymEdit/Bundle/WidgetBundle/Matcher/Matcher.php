<?php

namespace SymEdit\Bundle\WidgetBundle\Matcher;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class Matcher
{
    protected $voters;

    public function __construct($voters = array())
    {
        $this->voters = $voters;
    }

    public function addVoter(VoterInterface $voter)
    {
        $this->voters[] = $voter;
    }

    public function isVisible(WidgetInterface $widget)
    {
        foreach ($this->voters as $voter) {
            if ($voter->isVisible($widget)) {
                return true;
            }
        }

        return false;
    }
}