<?php

namespace SymEdit\Bundle\ShortcodeBundle\Renderer;

class ShortcodeRenderer implements ShortcodeRendererInterface
{
    protected $shortcodes;
    protected $pattern = '#\[(%s)(?:\s(.*?))?\](?:(.+?)(?:\[\/\1\]))?#';
    protected $attrPattern = '#([\w-]+)(?:\s*=\s*([^\s]+))?#';

    public function __construct($shortcodes = array())
    {
        $this->shortcodes = $shortcodes;
    }

    public function renderString($string)
    {
        return preg_replace_callback($this->getRegex(), array($this, 'parseCode'), $string);
    }

    protected function parseAttrs($attr)
    {
        preg_match_all($this->attrPattern, $attr, $matches, PREG_SET_ORDER);

        $finalAttrs = array();

        foreach ($matches as $match) {
            if (!isset($match[2])) {
                $finalAttrs[] = $match[1];
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

        return $this->renderString($response);
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