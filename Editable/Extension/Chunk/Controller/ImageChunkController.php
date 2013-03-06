<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Controller; 

use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Isometriks\Bundle\SymEditBundle\Entity\Chunk; 
use Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\Form\ImageType; 
use Isometriks\Bundle\SymEditBundle\Entity\Image; 

/**
 * @Route("/chunk/image")
 */
class ImageChunkController extends ChunkController
{
    /**
     * @Route("/{id}/update", name="editable_chunk_image_update")
     */
    public function updateAction(Request $request, Chunk $chunk)
    {
        $form = $this->createForm($chunk->getStrategy()->getForm()); 
        $form->bind($request); 
        
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager(); 
            
            // If the image exists, overwrite it. 
            if($chunk->hasOption('image_id')){
                $image = $em->getRepository('IsometriksSymEditBundle:Image')->find($chunk->getOption('image_id')); 
            } else {
                $image = new Image(); 
                $image->setName($chunk->getOption('image_name'));
            }
            
            $data = $form->getData(); 
            $image->setFile($data['image']); 
            
            $em->persist($image); 
            $em->flush(); 
            
            $chunk->setOption('image_id', $image->getId()); 
            $chunk->setOption('src', $image->getWebPath()); 
 
            $this->saveChunk($chunk);  
            
            return new JsonResponse(array(
                'src' => $image->getWebPath(), 
                'status' => true, 
            )); 
        }
        
        return new JsonResponse(array(
            'status' => false, 
        ));
    }
}