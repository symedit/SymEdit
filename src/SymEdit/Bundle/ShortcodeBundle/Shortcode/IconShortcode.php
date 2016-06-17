<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ShortcodeBundle\Shortcode;

/**
 * Renders icons. Icon Pattern like: "<i class="fa fa-%s"></i>" or "<i class="icon-%s"></i>".
 */
class IconShortcode extends AbstractShortcode
{
    protected static $patterns = [
        'glyphicon' => '<span class="glyphicon glyphicon-%s"></span>',
        'fontawesome' => '<i class="icon-%s"></i>',
        'fontawesome4' => '<i class="fa fa-%s"></i>',
    ];

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
