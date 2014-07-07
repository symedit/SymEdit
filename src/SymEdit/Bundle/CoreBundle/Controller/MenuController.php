<?php

namespace SymEdit\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    public function renderAction(Request $request)
    {
        $lastUpdated = $this->getPageRepository()->getLastUpdated();

        $response = new Response();
        $response
            ->setLastModified($lastUpdated)
            ->setPublic();

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $this->render('@SymEdit/Menu/render.html.twig', array(), $response);
    }

    protected function getPageRepository()
    {
        return $this->get('symedit.repository.page');
    }
}