<?php

namespace SymEdit\Bundle\ThemeBundle\Theme;

interface ThemeFactoryInterface
{
    /**
     * Get Theme by Name
     */
    public function getTheme($name);
}