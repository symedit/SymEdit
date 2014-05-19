<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
