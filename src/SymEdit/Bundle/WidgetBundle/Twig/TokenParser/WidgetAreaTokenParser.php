<?php

namespace SymEdit\Bundle\WidgetBundle\Twig\TokenParser;

use SymEdit\Bundle\WidgetBundle\Twig\Node\WidgetAreaNode;

class WidgetAreaTokenParser extends \Twig_TokenParser
{
    protected $strategy;

    public function __construct($strategy)
    {
        $this->strategy = $strategy;
    }

    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $area = $stream->expect(\Twig_Token::STRING_TYPE)->getValue();

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return $this->getWidgetAreaNode($area, $this->strategy, $lineno, $this->getTag());
    }
    
    /**
     * Allows this to be overriden
     */
    protected function getWidgetAreaNode($area, $strategy, $lineno, $tag)
    {
        return new WidgetAreaNode($area, $strategy, $lineno, $tag);
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @param string The tag name
     */
    public function getTag()
    {
        return 'widgetarea';
    }
}
