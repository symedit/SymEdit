<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Strategy; 

use Isometriks\Bundle\SymEditBundle\Entity\Chunk;
use Symfony\Component\OptionsResolver\OptionsResolverInterface; 
use Symfony\Component\Form\FormFactory; 
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

abstract class AbstractChunkStrategy implements ChunkStrategyInterface
{
    protected $options = array(); 
    protected $templating; 
    
    public function setDefaultOptions(OptionsResolverInterface $resolver, Chunk $chunk)
    {
    }
    
    public function getUpdatePath()
    {
        return 'editable_chunk_update';
    }
    
    public function edit(Chunk $chunk, EngineInterface $templating, FormFactory $factory)
    {
        $formType = $this->getForm();
        $form = $factory->create($formType, $chunk); 
        
        return $templating->render('IsometriksSymEditBundle:Editable/Chunk:edit.html.twig', array(
            'form' => $form->createView(), 
            'chunk' => $chunk, 
        ));
    }
}