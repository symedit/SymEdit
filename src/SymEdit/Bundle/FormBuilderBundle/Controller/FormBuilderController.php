<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\FormBuilderBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use SymEdit\Bundle\FormBuilderBundle\Event\Events;
use SymEdit\Bundle\FormBuilderBundle\Event\GetResponseFormBuilderResultEvent;
use SymEdit\Bundle\FormBuilderBundle\Form\FormBuilderFactoryInterface;
use SymEdit\Bundle\FormBuilderBundle\Form\FormProcessorInterface;
use Symfony\Component\HttpFoundation\Request;

class FormBuilderController extends ResourceController
{
    public function previewAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $resource = $this->findOr404($configuration);

        return $this->render('@SymEdit/Admin/FormBuilder/preview.html.twig', [
            'form_builder' => $resource,
            'form' => $this->getFactory()->build($resource)->createView(),
        ]);
    }

    public function processAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $resource = $this->findOr404($configuration);
        $form = $this->getFactory()->build($resource);

        if ($form->handleRequest($request)->isValid()) {

            // Get Result
            $result = $this->getFormProcessor()->process($resource, $form);

            // Dispatch Success Event
            $event = new GetResponseFormBuilderResultEvent($result);
            $this->get('event_dispatcher')->dispatch(Events::FORM_SUCCESS, $event);

            if (($response = $event->getResponse()) !== null) {
                return $response;
            }

            return $this->redirectToRoute('symedit_form_builder_success', [
                'name' => $resource->getName(),
            ]);
        }

        return $this->render('@SymEdit/FormBuilder/process.html.twig', [
            'form_builder' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return FormBuilderFactoryInterface
     */
    protected function getFactory()
    {
        return $this->get('symedit_form_builder.form.factory');
    }

    /**
     * @return FormProcessorInterface
     */
    protected function getFormProcessor()
    {
        return $this->get('symedit_form_builder.form.processor');
    }
}
