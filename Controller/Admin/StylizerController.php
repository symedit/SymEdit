<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin; 

use Symfony\Bundle\FrameworkBundle\Controller\Controller; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template; 
use Symfony\Component\HttpFoundation\Request; 

/**
 * @Route("/stylizer")
 */
class StylizerController extends Controller
{
    /**
     * @Route("/", name="admin_stylizer")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $stylizer = $this->get('isometriks_stylizer.stylizer'); 
        $form = $this->createForm('styles', $stylizer); 
        
        if($request->getMethod() === 'POST'){
            
            $form->bind($request); 
            
            if($form->isValid()){
                
                $stylizer->save(); 
                $fb = $this->get('session')->getFlashBag();                 
                
                if($request->request->has('dump')){
                    $stylizer->dump(); 
                    
                    $fb->add('notice', 'Styles saved and dumped'); 
                } else {
                    $fb->add('notice', 'Styles Saved'); 
                }
            }
        }
        
        return array(
            'form' => $form->createView(), 
        ); 
    }
}