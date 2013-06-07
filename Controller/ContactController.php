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
        
        $response = $this->createResponse($_page->getUpdatedAt()); 
        
        if ($request->getMethod() === 'POST') {

            /**
             * Set the response to private in case the validation fails, 
             * preventing the errors from being cached. 
             */
            $response->setPrivate(); 
            
            $form->bind($request);

            if ($form->isValid()) {

                $mailer = $this->get('symedit.mailer'); 
                $mailer->sendAdmin('Contact Form Submission', $this->getHostTemplate('Contact', 'contact.txt.twig'), array(
                    'Form' => $form->getData()
                )); 

                return $this->render($this->getHostTemplate('Contact', 'success.html.twig'));
            }
            
        } elseif ($response->isNotModified($request)) {
            
            /**
             * We can only return this response if it is the public one
             */
            return $response; 
        }
        
        return $this->render($this->getHostTemplate('Contact', 'index.html.twig'), array(
            'form' => $form->createView(), 
        ), $response);
    }
}