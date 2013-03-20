<?php

namespace Isometriks\Bundle\StylizerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request; 

class DefaultController extends Controller
{
    /**
     * @Route("/stylizer")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $stylizer = $this->get('isometriks_stylizer.stylizer'); 
        $form = $this->createForm('styles', $stylizer);
        
        if($request->getMethod() === 'POST'){
            
            $form->bind($request); 
            
            if($form->isValid()){
                echo 'valid form..'; 
                
                $stylizer->save(); 
                
            } else {
                echo 'invalid form..'; 
            }
            
            die('end post..'); 
            
        } else {
              

            return array(
                'form' => $form->createView(), 
            );
        }
    }
}
