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
        if ($code = $this->getWebmasterSettings()->get('webmaster.google_verify')) {
            if (strpos($code, 'google') === 0) {
                $code = substr($code, 6);
            }

            if ($code === $request_code) {
                return $this->render('@SymEdit/Webmaster/googleVerify.html.twig', array(
                    'code' => $code,
                ));
            }
        }

        throw $this->createNotFoundException();
    }

    public function bingVerifyAction()
    {
        if ($code = $this->getWebmasterSettings()->get('bing_verify')) {
            return $this->render('@SymEdit/Webmaster/bingVerify.xml.twig', array(
                'code' => $code,
            ));
        }

        throw $this->createNotFoundException();
    }

    public function robotsAction()
    {
        $allow = $this->getWebmasterSettings()->get('robots') === 'allow';

        return $this->render('@SymEdit/Crawler/robots.txt.twig', array(
            'Allow' => $allow,
        ));
    }

    protected function getWebmasterSettings()
    {
        return $this->get('sylius.settings.manager')->loadSettings('webmaster');
    }
}
