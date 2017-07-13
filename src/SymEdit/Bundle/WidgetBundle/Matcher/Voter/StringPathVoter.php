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

use SymEdit\Bundle\WidgetBundle\Model\Widget;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;

/**
 * This is mostly used as a parent class but you can also inject
 * a specific string into the constructor to test for it in your
 * associations.
 */
class StringPathVoter implements VoterInterface
{
    protected $string;

    public function __construct($string = null)
    {
        $this->string = $string;
    }

    public function getString()
    {
        return $this->string;
    }

    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    public function isVisible(WidgetInterface $widget)
    {
        return $this->checkValue($widget, $this->string);
    }

    protected function checkValue(WidgetInterface $widget, $value)
    {
        $foundAssociation = $this->checkAssociation($widget, $value);

        return ($widget->getVisibility() === Widget::INCLUDE_ONLY && $foundAssociation) ||
               ($widget->getVisibility() === Widget::EXCLUDE_ONLY && !$foundAssociation);
    }

    protected function checkAssociation(WidgetInterface $widget, $string)
    {
        $string = rtrim($string, '/');

        foreach ($widget->getAssoc() as $assoc) {
            $assoc = $this->cleanAssociation($assoc);

            if (strpos($assoc, '*') !== false) {
                $exp = sprintf('#%s#i', str_replace('\*', '.+?', preg_quote($assoc)));

                if (preg_match($exp, $string)) {
                    return true;
                }
            }

            if ($string === $assoc) {
                return true;
            }
        }

        return false;
    }

    protected function cleanAssociation($assoc)
    {
        return rtrim($assoc, '/');
    }
}
