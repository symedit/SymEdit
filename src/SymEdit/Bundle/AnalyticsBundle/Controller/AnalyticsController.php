<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnalyticsController extends Controller
{
    public function recordAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return new Response('', 403);
        }

        $recorder = $this->get('symedit_analytics.recorder');
        $data = $request->request->get('visits', []);

        foreach ($data as $visitData) {
            if (!isset($visitData['m']) || !isset($visitData['i'])) {
                continue;
            }

            $recorder->record($visitData['m'], $visitData['i']);
        }

        // Flush recorded visits
        $recorder->flush();

        // Send 200
        return new Response();
    }
}
