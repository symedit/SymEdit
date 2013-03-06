<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Strategy;

use Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Form\HtmlType;
use Isometriks\Bundle\SymEditBundle\Entity\Chunk; 
use Symfony\Component\OptionsResolver\OptionsResolverInterface; 
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface; 
use Symfony\Component\Form\FormFactory; 

class HtmlStrategy extends AbstractChunkStrategy
{
    public function getForm()
    {
        return new HtmlType(); 
    }    
    
    public function setDefaultOptions(OptionsResolverInterface $resolver, Chunk $chunk)
    {
        $resolver->setDefaults(array(
            'html' => sprintf('HTML Chunk "%s"', $chunk->getName()), 
        ));
    }

    public function getName()
    {
        return 'html'; 
    }

    public function render(Chunk $chunk, EngineInterface $templating, FormFactory $factory)
    {
        return $chunk->getOption('html'); 
    }
}