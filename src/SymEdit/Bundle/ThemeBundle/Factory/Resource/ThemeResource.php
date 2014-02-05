<?php

namespace SymEdit\Bundle\ThemeBundle\Factory\Resource;

use Assetic\Factory\Resource\ResourceInterface;
use SymEdit\Bundle\ThemeBundle\Model\Theme;

class ThemeResource implements ResourceInterface
{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function __toString()
    {
        return 'symedit_theme';
    }

    public function getContent()
    {
        $cssFormula = array(
            $this->theme->getStylesheets(),
            array(),
            array(
                'output' => $this->theme->getPublicDirectory().'/styles.css',
            ),
        );

        $jsFormula = array(
            $this->theme->getJavascripts(),
            array(),
            array(
                'output' => $this->theme->getPublicDirectory().'/scripts.js',
            ),
        );

        return array(
            'theme_css' => $cssFormula,
            'theme_js' => $jsFormula
        );
    }

    public function isFresh($timestamp)
    {
        return true;
    }
}