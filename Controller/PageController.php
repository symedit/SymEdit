<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager(); 
        
        if(!$page = $em->getRepository('IsometriksSymEditBundle:Page')->find($id)){
            throw $this->createNotFoundException(sprintf('Page with ID %d not found', $id)); 
        }
        
        $response = $this->createResponse($page->getUpdatedAt());  

        if ($response->isNotModified($request)) {
            return $response;
        }

        /**
         * Insert Page variable into the Request headers
         */
        $request->attributes->add(array(
            '_page' => $page,
        ));

        return $this->render($this->getHostTemplate('Page', $page->getTemplate()), array(
            'SEO' => $page->getSeo(),
        ), $response);
    }
}
