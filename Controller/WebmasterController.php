<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WebmasterController extends Controller
{
    /**
     * @Route("/google{request_code}.html", requirements={"request_code"="[a-z0-9]{16}"})
     * @Template()
     */
    public function googleVerifyAction($request_code)
    {
        $settings = $this->get('isometriks_settings.settings');

        if ($settings->has('webmaster.google_verify')) {
            $code = $settings->get('webmaster.google_verify');

            if (strpos($code, 'google') === 0) {
                $code = substr($code, 6);
            }

            if ($code === $request_code) {
                return array(
                    'code' => $code,
                );
            }
        }

        throw $this->createNotFoundException();
    }

    /**
     * @Route("/BingSiteAuth.{_format}", defaults={"_format"="xml"})
     * @Template()
     */
    public function bingVerifyAction()
    {
        $settings = $this->get('isometriks_settings.settings');

        if ($settings->has('webmaster.bing_verify')) {
            $code = $settings->get('webmaster.bing_verify');

            return array(
                'code' => $code,
            );
        }

        throw $this->createNotFoundException();
    }
}