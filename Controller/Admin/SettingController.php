<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Isometriks\Bundle\SymEditBundle\Form\SettingsType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize; 

/**
 * Page controller.
 *
 * @Route("/setting")
 * @PreAuthorize("hasRole('ROLE_ADMIN_SETTING')")
 */
class SettingController extends Controller {

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="admin_setting")
     * @Template()
     */
    public function indexAction()
    {
        $settings = $this->get('isometriks_settings.settings');        
        $form     = $this->createForm('settings', $settings);

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Edits an existing Page entity.
     *
     * @Route("/update", name="admin_setting_update")
     * @Method("POST")
     */
    public function updateAction(Request $request)
    {
        $settings = $this->get('isometriks_settings.settings');
        $form     = $this->createForm('settings', $settings);

        $form->bind($request);

        if ($form->isValid()) {            
            $settings->save(); 
            
            $this->get('session')->getFlashBag()->add('notice', 'Settings Updated'); 
        }

        return $this->redirect($this->generateUrl('admin_setting'));
    }

}
