<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Controller; 

use Symfony\Bundle\FrameworkBundle\Controller\Controller; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\JsonResponse; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Isometriks\Bundle\SymEditBundle\Entity\Chunk; 

/**
 * @Route("/chunk")
 */
class ChunkController extends Controller
{
    /**
     * @Route("/{id}/update", name="editable_chunk_update")
     */
    public function updateAction(Request $request, Chunk $chunk)
    {
        $status = false; 
        $form = $this->createForm($chunk->getStrategy()->getForm(), $chunk);  
        $form->bind($request); 
        
        if($form->isValid()){
            $status = true;  
            
            $this->saveChunk($chunk); 
        }
        
        return new JsonResponse(array('status' => $status)); 
    }
    
    protected function saveChunk(Chunk $chunk)
    {
        $manager = $this->get('symedit.editable.chunk.manager'); 
        $manager->save($chunk); 
    }
}