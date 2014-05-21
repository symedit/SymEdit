<?php

namespace SymEdit\Bundle\ShortcodeBundle\Shortcode;

interface ShortcodeInterface
{
    /**
     * Get the name aka [name {expression here}]
     */
    public function getName();

    /**
     * Returns a string with the result in it. This could use twig
     * or just return a string
     */
    public function renderShortcode($match, array $attr, $content);

    /**
     * If we use this tag, can we still cache the outcome?
     */
    public function isCacheable();
}