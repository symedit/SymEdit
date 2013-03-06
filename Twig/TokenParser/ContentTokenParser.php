<?php

namespace Isometriks\Bundle\SymEditBundle\Twig\TokenParser;

use Isometriks\Bundle\SymEditBundle\Twig\Node\EditableNode;

class ContentTokenParser extends \Twig_TokenParser
{
    /**
     * Parses a token and returns a node.
     *
     * @param Twig_Token $token A Twig_Token instance
     *
     * @return Twig_NodeInterface A Twig_NodeInterface instance
     */
    public function parse(\Twig_Token $token)
    {
        $this->expressionParser = $this->parser->getExpressionParser();
        $lineno = $token->getLine();

        $expr = $this->expressionParser->parseExpression();
        $this->parser->getStream()->expect(\Twig_Token::BLOCK_END_TYPE);

        $subject   = $expr->getNode('node');
        $const     = $expr->getNode('attribute');
        $attribute = $const->getAttribute('value');

        $params = new \Twig_Node_Expression_Array(array(
            new \Twig_Node_Expression_Constant('attribute', $lineno),
            new \Twig_Node_Expression_Constant($attribute, $lineno),
        ), $lineno);

        return new EditableNode($subject, 'entityattribute', $params, $lineno, $this->getTag());
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @param string The tag name
     */
    public function getTag()
    {
        return 'content';
    }
}
