<?php

namespace SymEdit\Bundle\AnalyticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnalyticsController extends Controller
{
    public function recordAction(Request $request)
    {
        if ($request->getClientIp() !== '127.0.0.1') {
            return new Response('', 403);
        }

        $recorder = $this->get('symedit_analytics.recorder');
        $data = $request->request->get('visits', array());

        foreach ($data as $visitData) {
            if (!isset($visitData['c']) || !isset($visitData['i'])) {
                continue;
            }

            $recorder->record($visitData['c'], $visitData['i']);
        }

        // Flush recorded visits
        $recorder->flush();

        // Send 200
        return new Response();
    }
}
