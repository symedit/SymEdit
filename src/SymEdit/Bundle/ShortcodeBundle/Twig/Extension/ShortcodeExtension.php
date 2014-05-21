<?php

namespace SymEdit\Bundle\ShortcodeBundle\Twig\Extension;

use SymEdit\Bundle\ShortcodeBundle\Renderer\ShortcodeRendererInterface;

/**
 * @TODO: Should we inject the container here and load the renderer
 * when it's used instead? I think this will force everything to be
 * loaded on every template render.
 */
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