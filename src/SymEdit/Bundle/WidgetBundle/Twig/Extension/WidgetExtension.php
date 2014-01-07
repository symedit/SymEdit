<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Twig\Extension;

use SymEdit\Bundle\WidgetBundle\Twig\TokenParser;

class WidgetExtension extends \Twig_Extension
{
    protected $strategy;

    public function __construct($strategy)
    {
        $this->strategy = $strategy;
    }

    public function getTokenParsers()
    {
        return array(
            new TokenParser\WidgetAreaTokenParser($this->strategy),
        );
    }
    
    public function getName()
    {
        return 'symedit_widget';
    }
}