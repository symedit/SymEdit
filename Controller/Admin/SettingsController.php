<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Isometriks\Bundle\SymEditBundle\Controller\ResourceController;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\HttpFoundation\Request;

/**
 * Settings controller.
 *
 * @PreAuthorize("hasRole('ROLE_ADMIN_SETTING')")
 */
class SettingsController extends ResourceController
{
    public function indexAction(Request $request)
    {
        $settings = $this->get('isometriks_settings.settings');
        $form = $this->createSettingsForm($settings);

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Settings/index.html.twig')
            ->setData(array(
                'settings' => $settings->getSettings(),
                'form' => $form->createView(),
            ));

        return $this->handleView($view);
    }

    protected function createSettingsForm($settings)
    {
        return $this->createForm('settings', $settings, array(
            'action' => $this->generateUrl('admin_settings_update'),
            'method' => 'POST',
        ));
    }

    /**
     * Edits an existing Page entity.
     *
     */
    public function updateAction(Request $request)
    {
        $config = $this->getConfiguration();

        $settings = $this->get('isometriks_settings.settings');
        $form = $this->createSettingsForm($settings);

        if (($request->isMethod('PUT') || $request->isMethod('POST')) && $form->bind($request)->isValid()) {
            $event = $this->update($settings);
            if (!$event->isStopped()) {
                $this->setFlash('success', 'update');

                return $this->redirectTo($settings);
            }

            $this->setFlash($event->getMessageType(), $event->getMessage(), $event->getMessageParams());
        }

        if ($config->isApiRequest()) {
            return $this->handleView($this->view($form));
        }

        $view = $this
            ->view()
            ->setTemplate($config->getTemplate('update.html'))
            ->setData(array(
                'settings' => $settings,
                'form'     => $form->createView()
            ))
        ;

        return $this->handleView($view);
    }

    public function update($settings)
    {
        $event = $this->dispatchEvent('pre_update', $settings);
        if (!$event->isStopped()) {
            $settings->save();
        }

        return $event;
    }
}
