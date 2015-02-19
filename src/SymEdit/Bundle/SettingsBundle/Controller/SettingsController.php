<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use SymEdit\Bundle\SettingsBundle\Model\Settings;
use Symfony\Component\HttpFoundation\Request;

/**
 * Settings controller.
 */
class SettingsController extends FOSRestController
{
    public function indexAction(Request $request)
    {
        $settings = $this->getSettings();
        $form = $this->getForm($request, $settings);

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Settings/index.html.twig')
            ->setData(array(
                'settings' => $settings->getSettings(),
                'form' => $form->createView(),
            ));

        return $this->handleView($view);
    }

    public function updateAction(Request $request)
    {
        $settings = $this->getSettings();
        $form = $this->getForm($request, $settings);

        if ($form->submit($request, !$request->isMethod('PATCH'))->isValid()) {
            $settings->save();

            if ($this->isApiRequest($request)) {
                return $this->handleView($this->view($settings, 204));
            }
        }

        if ($this->isApiRequest($request)) {
            return $this->handleView($this->view($form, 400));
        }

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Settings/index.html.twig')
            ->setData(array(
                'settings'  => $settings->getSettings(),
                'form'      => $form->createView(),
            ))
        ;

        return $this->handleView($view);
    }

    protected function isApiRequest(Request $request)
    {
        return $request->getRequestFormat() !== 'html';
    }

    protected function getForm(Request $request, $resource = null)
    {
        if ($this->isApiRequest($request)) {
            return $this->getApiForm($resource);
        }

        return $this->createForm('symedit_settings', $resource);
    }

    protected function getApiForm($resource = null)
    {
        return $this->get('form.factory')->createNamed('', 'symedit_settings', $resource, array(
            'csrf_protection' => false,
        ));
    }

    /**
     * @return Settings
     */
    protected function getSettings()
    {
        return $this->get('symedit_settings.settings');
    }
}
