<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ShortcodeBundle\Renderer;

class ShortcodeRenderer implements ShortcodeRendererInterface
{
    protected $shortcodes;
    protected $pattern = '#\[(%s)(?:\s(.*?))?\](?:(.+?)(?:\[\/\1\]))?#';
    protected $attrPattern = '#([\w\d-_\.]+)\s*=\s*(?:(?:\"(.+)\")|([^\s]+))#';

    public function __construct($shortcodes = [])
    {
        $this->shortcodes = $shortcodes;
    }

    public function renderString($string)
    {
        return preg_replace_callback($this->getRegex(), [$this, 'parseCode'], $string);
    }

    protected function parseAttrs($attr)
    {
        preg_match_all($this->attrPattern, $attr, $matches, PREG_SET_ORDER);

        $finalAttrs = [];

        foreach ($matches as $match) {
            // Matched one with quotes, so 2 is empty
            if (empty($match[2])) {
                $finalAttrs[$match[1]] = $match[3];
            // Matched without quotes
            } else {
                $finalAttrs[$match[1]] = $match[2];
            }
        }

        return $finalAttrs;
    }

    protected function parseCode($parts)
    {
        list($match, $tagName, $attr) = $parts;

        $shortcode = $this->getShortcode($tagName);
        $response = $shortcode->renderShortcode($match, $this->parseAttrs($attr), isset($parts[3]) ? $parts[3] : null);

        // Prevent infinite loop trying to resolve a non-match
        return ($response !== $match) ? $this->renderString($response) : $response;
    }

    protected function getRegex()
    {
        return sprintf($this->pattern, implode('|', $this->getShortcodeTags()));
    }

    protected function getShortcodeTags()
    {
        return array_keys($this->shortcodes);
    }

    /**
     * @return ShortcodeInterface
     */
    protected function getShortcode($name)
    {
        return $this->shortcodes[$name];
    }
}
