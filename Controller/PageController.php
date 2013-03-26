<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SymEditBundle\Entity\Page;

class PageController extends Controller
{
    public function showAction(Page $page, Request $request)
    {
        $response = $this->createResponse($page->getUpdatedAt());  

        if ($response->isNotModified($request)) {
            return $response;
        }

        /**
         * Set the page active up to root
         */
        $page->setActive(true, true);

        /**
         * Insert Page variable into the Request headers
         */
        $request->attributes->add(array(
            '_page' => $page,
        ));

        return $this->render($this->getHostTemplate('Page', $page->getTemplate()), array(
            'Page' => $page,
            'SEO' => $page->getSeo(),
        ), $response);
    }
}
