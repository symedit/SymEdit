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

class WebmasterController extends Controller
{
    public function googleVerifyAction($request_code)
    {
        $settings = $this->get('symedit_settings.settings');

        if ($settings->has('webmaster.google_verify')) {
            $code = $settings->get('webmaster.google_verify');

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
        $settings = $this->get('symedit_settings.settings');

        if ($settings->has('webmaster.bing_verify')) {
            $code = $settings->get('webmaster.bing_verify');

            return $this->render('@SymEdit/Webmaster/bingVerify.xml.twig', array(
                'code' => $code,
            ));
        }

        throw $this->createNotFoundException();
    }
}
