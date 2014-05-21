<?php

namespace SymEdit\Bundle\ShortcodeBundle\Shortcode;

/**
 * Renders icons. Icon Pattern like: "<i class="fa fa-%s"></i>" or "<i class="icon-%s"></i>"
 */
class IconShortCode extends AbstractShortcode
{
    protected $iconPattern;

    public function construct($iconPattern = '')
    {
        $this->iconPattern = $iconPattern;
    }

    public function renderShortcode($match, array $attr, $content)
    {
        $icon = current($attr);

        return sprintf('<i class="icon-%s"></i>', $icon);
    }

    public function getName()
    {
        return 'icon';
    }
}
