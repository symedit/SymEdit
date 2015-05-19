<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Event;

use SymEdit\Bundle\ThemeBundle\Model\ThemeInterface;
use Symfony\Component\EventDispatcher\Event;

class ThemeEvent extends Event
{
    protected $theme;

    public function __construct(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get the theme.
     *
     * @return ThemeInterface
     */
    public function getTheme()
    {
        return $this->theme;
    }
}
