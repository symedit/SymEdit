<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebmasterController extends Controller
{
    public function googleVerifyAction($request_code)
    {
        $code = $this->getWebmasterSettings()->get('google_verify');

        if ($code) {
            if (strpos($code, 'google') === 0) {
                $code = substr($code, 6);
            }

            if ($code === $request_code) {
                return $this->render('@SymEdit/Webmaster/googleVerify.html.twig', [
                    'code' => $code,
                ]);
            }
        }

        throw $this->createNotFoundException();
    }

    public function bingVerifyAction()
    {
        $code = $this->getWebmasterSettings()->get('bing_verify');

        if ($code) {
            return $this->render('@SymEdit/Webmaster/bingVerify.xml.twig', [
                'code' => $code,
            ]);
        }

        throw $this->createNotFoundException();
    }

    public function robotsAction()
    {
        $allow = $this->getWebmasterSettings()->get('robots') === 'allow';

        return $this->render('@SymEdit/Crawler/robots.txt.twig', [
            'Allow' => $allow,
        ]);
    }

    protected function getWebmasterSettings()
    {
        return $this->get('symedit.settings_manager')->load('webmaster');
    }
}
