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
use Sylius\Bundle\ResourceBundle\Controller\Configuration;
use SymEdit\Bundle\SettingsBundle\Model\Settings;
use Symfony\Component\HttpFoundation\Request;

/**
 * Settings controller.
 */
class SettingsController extends FOSRestController
{
    protected $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    public function indexAction(Request $request)
    {
        $this->config->setRequest($request);

        $settings = $this->getSettings();
        $form = $this->getForm($settings);

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setData(array(
                'settings' => $settings->getSettings(),
                'form' => $form->createView(),
            ));

        return $this->handleView($view);
    }

    public function updateAction(Request $request)
    {
        $this->config->setRequest($request);

        $settings = $this->getSettings();
        $form = $this->getForm($settings);
        $form->handleRequest($request);

        if ($request->isMethod('PUT') || $request->isMethod('POST') && $form->isValid()) {
            $settings->save();
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('update.html'))
            ->setData(array(
                'settings'  => $settings->getSettings(),
                'form'      => $form->createView(),
            ))
        ;

        return $this->handleView($view);
    }

    public function getForm($resource = null)
    {
        return $this->createForm($this->config->getFormType(), $resource);
    }

    /**
     * @return Settings
     */
    protected function getSettings()
    {
        return $this->get('symedit_settings.settings');
    }
}
