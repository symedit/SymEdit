<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk; 

use Symfony\Component\OptionsResolver\OptionsResolver; 
use Doctrine\Bundle\DoctrineBundle\Registry; 
use Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\ChunkRegistry; 
use Isometriks\Bundle\SymEditBundle\Entity\Page; 
use Isometriks\Bundle\SymEditBundle\Entity\Chunk; 

class ChunkManager
{
    private $doctrine; 
    private $registry; 
    
    public function __construct(Registry $doctrine, ChunkRegistry $registry)
    {
        $this->doctrine = $doctrine; 
        $this->registry = $registry; 
    }
    
    /**
     * Update the pages updated time to prevent caching issues
     * Page objects are set to cascade persist to chunks so we don't
     * need to persist them explicitly. 
     *
     * @param \Isometriks\Bundle\SymEditBundle\Entity\Chunk $chunk
     */
    public function save(Chunk $chunk)
    {
        $page = $chunk->getPage(); 
        $page->setUpdatedAt(new \DateTime()); 
        
        $em = $this->doctrine->getManager(); 
        $em->persist($page); 
        $em->flush(); 
    }
    
    /**
     * 
     * @param \Isometriks\Bundle\SymEditBundle\Entity\Page $page
     * @param string $name
     * @param string $strategy
     * @param array $options
     * @return \Isometriks\Bundle\SymEditBundle\Entity\Chunk
     */
    public function create(Page $page, $name, $strategy, $options)
    {
        $chunk = new Chunk(); 
        $chunk->setStrategyName($strategy); 
        $chunk->setName($name); 
        
        // Attach strategy to chunk
        $this->registry->injectStrategy($chunk); 
        
        // Resolve default options
        $resolver = new OptionsResolver(); 
        $chunk->getStrategy()->setDefaultOptions($resolver, $chunk); 
        $chunk->setOptions($resolver->resolve($options)); 
        
        // Add chunk to page
        $page->addChunk($chunk); 
        
        // Save new chunk
        $em = $this->doctrine->getManager(); 
        $em->persist($page); 
        $em->flush(); 
        
        return $chunk; 
    }
}