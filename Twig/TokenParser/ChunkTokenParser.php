<?php

namespace Isometriks\Bundle\SymEditBundle\Twig\TokenParser; 

use Isometriks\Bundle\SymEditBundle\Twig\Node\EditableNode; 

/**
 * 
 *  {% chunk html with { name: 'leftbar' } %}
 * 
 */
class ChunkTokenParser extends \Twig_TokenParser
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
        $lineno = $token->getLine(); 
        $stream = $this->parser->getStream(); 
        $ep     = $this->parser->getExpressionParser(); 
        
        // Automatically use Page as current subject
        $subject = new \Twig_Node_Expression_Name('Page', $lineno);  
        
        $strategy = $stream->expect(\Twig_Token::NAME_TYPE)->getValue(); 
        
        if($stream->test(\Twig_Token::NAME_TYPE, 'with')){
            $stream->next(); 
            
            $parameters = $ep->parseExpression(); 
        } else {
            $parameters = new \Twig_Node_Expression_Array(array(), $lineno); 
        }
        
        $parameters->addElement(new \Twig_Node_Expression_Constant($strategy, $lineno), new \Twig_Node_Expression_Constant('strategy', $lineno));  
        
        $stream->expect(\Twig_Token::BLOCK_END_TYPE); 
        
        return new EditableNode($subject, 'chunk', $parameters, $lineno, $this->getTag()); 
    }

    /**
     * Gets the tag name associated with this token parser.
     *
     * @param string The tag name
     */
    public function getTag()
    {
        return 'chunk';
    }
}
