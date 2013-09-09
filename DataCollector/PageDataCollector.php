<?php

namespace Isometriks\Bundle\SymEditBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageDataCollector extends DataCollector
{
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if ($request->attributes->has('_page')) {
            $page = $request->attributes->get('_page');

            $this->data = array(
                'page' => $page,
                'controller' => $request->attributes->get('_controller'),
            );
        } else {
            $this->data['page'] = null;
        }
    }

    public function getPage()
    {
        return $this->data['page'];
    }

    public function getController()
    {
        return $this->data['controller'];
    }

    public function getName()
    {
        return 'symedit_page';
    }
}