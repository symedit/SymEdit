<?php

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
     * Get the theme
     *
     * @return ThemeInterface
     */
    public function getTheme()
    {
        return $this->theme;
    }
}