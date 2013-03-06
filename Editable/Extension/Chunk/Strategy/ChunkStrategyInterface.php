<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Strategy; 

use Isometriks\Bundle\SymEditBundle\Entity\Chunk; 
use Symfony\Component\OptionsResolver\OptionsResolverInterface; 
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface; 
use Symfony\Component\Form\FormFactory; 

interface ChunkStrategyInterface
{
    /**
     * Gets default options
     * @return array|null $options
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver, Chunk $chunk); 
    
    /**
     * Get form for editing
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getForm(); 
    
    /**
     * Get name of strategy
     */
    public function getName(); 
    
    /**
     * Get path to render in twig for updating the chunk
     */
    public function getUpdatePath(); 
    
    public function render(Chunk $chunk, EngineInterface $templating, FormFactory $factory); 
    public function edit(Chunk $chunk, EngineInterface $templating, FormFactory $factory);
}