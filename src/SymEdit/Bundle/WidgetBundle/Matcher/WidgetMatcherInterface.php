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

interface WidgetMatcherInterface
{
    /**
     * Add a new voter to the matcher.
     *
     * @param VoterInterface $voter
     */
    public function addVoter(VoterInterface $voter);

    /**
     * Determine if a single widget is visible.
     *
     * @param WidgetInterface $widget
     *
     * @return bool Whether widget is visible or not
     */
    public function isVisible(WidgetInterface $widget);

    /**
     * Take array of widgets and return only the visible ones.
     *
     * @param array $widgets
     *
     * @return array
     */
    public function getVisible(\Traversable $widgets);
}
