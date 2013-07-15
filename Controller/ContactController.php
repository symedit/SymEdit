<?php

namespace Isometriks\Bundle\SymEditBundle\Controller; 

use Isometriks\Bundle\SymEditBundle\Annotation\PageController as Bind; 
use Isometriks\Bundle\SitemapBundle\Annotation\Sitemap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; 
use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface; 

/**
 * @Bind(name="symedit-contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/", name="contact")
     * @Sitemap()
     */
    public function indexAction(Request $request, PageInterface $_page)
    {
        $namespace = $this->getHostNamespace(); 
        
        $type = $namespace.'\\Form\\ContactType'; 
        $form = $this->createForm(new $type()); 
        
        if ($request->getMethod() === 'POST') {
        
            $form->bind($request);

            if ($form->isValid()) {
                
                $data = $form->getData();
                
                /**
                 * Set replyTo if it was sent so it's easier for people
                 * to email back. 
                 */
                $options = empty($data['email']) ? array() : array(
                    'replyTo' => $data['email'], 
                );
                
                $mailer = $this->get('isometriks_sym_edit.mailer'); 
                $mailer->sendAdmin($this->getHostTemplate('Contact', 'contact.html.twig'), array(
                    'Form' => $data, 
                ), $options); 

                return $this->render($this->getHostTemplate('Contact', 'success.html.twig'));
            }  
        }
        
        return $this->render($this->getHostTemplate('Contact', 'index.html.twig'), array(
            'form' => $form->createView(), 
        ));
    }
}