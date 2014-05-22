<?php

namespace SymEdit\Bundle\ShortcodeBundle\Shortcode;

/**
 * Renders icons. Icon Pattern like: "<i class="fa fa-%s"></i>" or "<i class="icon-%s"></i>"
 */
class IconShortCode extends AbstractShortcode
{
    protected static $patterns = array(
        'glyphicon'     => '<span class="glyphicon glyphicon-%s"></span>',
        'fontawesome'   => '<i class="icon-%s"></i>',
        'fontawesome4'  => '<i class="fa fa-%s"></i>',
    );

    public function renderShortcode($match, array $attr, $content)
    {
        $iconSet = $this->getSetting('icon', 'glyphicon');
        $pattern = isset(self::$patterns[$iconSet]) ? self::$patterns[$iconSet] : '[Invalid Icon Set]';

        $icon = current($attr);

        return sprintf($pattern, $icon);
    }

    public function getName()
    {
        return 'icon';
    }
}
