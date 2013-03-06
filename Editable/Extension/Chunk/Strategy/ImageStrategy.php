<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Strategy;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface; 
use Symfony\Component\Form\FormFactory; 
use Isometriks\Bundle\SymEditBundle\Entity\Chunk; 
use Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Form\ImageType; 

class ImageStrategy extends AbstractChunkStrategy
{
    public function getForm()
    {
        return new ImageType(); 
    }
    
    public function getUpdatePath()
    {
        return 'editable_chunk_image_update'; 
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver, Chunk $chunk)
    {
        $resolver->setRequired(array(
            'w', 'h', 
        ));
        
        $resolver->setOptional(array(
            'class', 
        ));
        
        $resolver->setDefaults(array(
            'image_name' => $chunk->getName(), 
        ));
    }

    public function render(Chunk $chunk, EngineInterface $templating, FormFactory $factory)
    {
        return $templating->render('IsometriksSymEditBundle:Editable/Chunk/image:render.html.twig', array(
            'chunk' => $chunk, 
        ));  
    }

    public function edit(Chunk $chunk, EngineInterface $templating, FormFactory $factory)
    {
        $form = $factory->create($this->getForm()); 
        
        return $templating->render('IsometriksSymEditBundle:Editable/Chunk/image:edit.html.twig', array(
            'form' => $form->createView(), 
            'chunk' => $chunk, 
        ));
    }    
    
    public function getName()
    {
        return 'image'; 
    }
}