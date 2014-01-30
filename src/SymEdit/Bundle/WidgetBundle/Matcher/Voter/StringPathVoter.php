<?php

namespace SymEdit\Bundle\WidgetBundle\Matcher\Voter;

use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;
use SymEdit\Bundle\WidgetBundle\Model\Widget;

/**
 * If visibility is set to INCLUDE_ALL then it should
 * be rendered regardless
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
            $assoc = rtrim($assoc, '/');

            if (strpos($assoc, '*') !== false) {
                $exp = sprintf('#%s#i', str_replace('\*', '.+?', preg_quote($assoc)));
            }

            if ($string === $assoc) {
                return true;
            }
        }

        return false;
    }
}