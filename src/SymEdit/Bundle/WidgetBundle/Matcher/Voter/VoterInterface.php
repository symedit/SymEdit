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

interface VoterInterface
{
    public function isVisible(WidgetInterface $widget);
}
