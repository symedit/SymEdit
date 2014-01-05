<?php

namespace SymEdit\Bundle\StylizerBundle\Twig\Extension;

use SymEdit\Bundle\StylizerBundle\Model\Stylizer;

class StylizerExtension extends \Twig_Extension
{
    protected $stylizer;

    public function __construct(Stylizer $stylizer)
    {
        $this->stylizer = $stylizer;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('google_fonts', array($this, 'renderGoogleFonts'), array('is_safe' => array('html'))),
        );
    }

    public function renderGoogleFonts()
    {
        $variables = $this->stylizer->getVariables();

        if (!isset($variables['google-fonts'])) {
            return;
        }

        $fonts = trim($variables['google-fonts'], "'");

        if ($fonts === null || empty($fonts) || $fonts === 'none') {
            return;
        }

        return sprintf('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=%s">', $fonts);
    }

    public function getName()
    {
        return 'stylizer_extension';
    }
}