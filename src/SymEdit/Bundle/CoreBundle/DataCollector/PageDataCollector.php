<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class PageDataCollector extends DataCollector
{
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if ($request->attributes->has('_page')) {
            $page = $request->attributes->get('_page');

            $this->data = [
                'page' => $page,
                'controller' => $request->attributes->get('_controller'),
            ];
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
