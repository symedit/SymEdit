<?php

namespace SymEdit\Bundle\ShortcodeBundle\Shortcode;

abstract class AbstractShortcode implements ShortcodeInterface
{
    public function isCacheable()
    {
        return true;
    }
}