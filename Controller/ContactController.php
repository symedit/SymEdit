<?php

namespace Isometriks\Bundle\SymEditBundle\Controller; 

use Isometriks\Bundle\SymEditBundle\Annotation\PageController as Bind; 
use Symfony\Bundle\FrameworkBundle\Controller\Controller; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Symfony\Component\HttpFoundation\Request;

/**
 * @Bind(name="symedit-contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $finder  = $this->get('isometriks_sym_edit.finder.resource_finder'); 

        $host_bundle = $finder->getBundle(); 
        $namespace   = $finder->getBundleNamespace(); 
        
        $type = $namespace.'\\Form\\ContactType'; 
        $form = $this->createForm(new $type()); 
        
        if ($request->getMethod() === 'POST') {

            $form->bind($request);

            if ($form->isValid()) {

                $mailer = $this->get('symedit.mailer'); 
                $mailer->sendAdmin('Contact Form Submission', $host_bundle.':Contact:contact.txt.twig', array(
                    'Form' => $form->getData()
                )); 

                return $this->render($host_bundle.':Contact:success.html.twig');
            }
        }
        
        return $this->render($host_bundle.':Contact:index.html.twig', array(
            'form' => $form->createView(), 
        ));
    }
}