<?php

namespace SymEdit\Bundle\ShortcodeBundle\Twig\Extension;

use SymEdit\Bundle\ShortcodeBundle\Renderer\ShortcodeRendererInterface;

class ShortcodeExtension extends \Twig_Extension
{
    protected $renderer;

    public function __construct(ShortcodeRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('shortcode', array($this, 'renderShortcodes')),
        );
    }

    public function renderShortcodes($string)
    {
        return $this->renderer->renderString($string);
    }

    public function getName()
    {
        return 'symedit_shortcode';
    }
}