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

use SymEdit\Bundle\FormBuilderBundle\Model\FormElementInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

class FormElementController extends ResourceController
{
    public function createAction(Request $request)
    {
        $type = $request->get('type');
        $formId = $request->get('formId');
        $formBuilder = $this->get('symedit.repository.form_builder')->find($formId);

        if ($formBuilder === null) {
            throw $this->createNotFoundException();
        }

        /* @var $formElement FormElementInterface */
        $formElement = $this->createNew();
        $formElement->setType($type);
        $formElement->setForm($formBuilder);
        $form = $this->getForm($formElement);

        if ($form->handleRequest($request)->isValid()) {
            $formElement = $this->domainManager->create($formElement);

            return $this->redirect($this->generateUrl('admin_form_show', array(
                'id' => $formBuilder->getId(),
            )));
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('create.html'))
            ->setData(array(
                'formBuilder' => $formBuilder,
                'formElement' => $formElement,
                'form' => $form->createView(),
            ))
        ;

        return $this->handleView($view);
    }

    public function chooseAction($formId)
    {
        $types = $this->get('symedit_form_builder.builder_registry')->getTypes();

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('@SymEdit/Admin/FormElement/choose.html.twig'))
            ->setData(array(
                'formId' => $formId,
                'types' => $types,
            ))
        ;

        return $this->handleView($view);
    }

    public function getForm($resource = null, array $options = array())
    {
        $form = $this->config->getFormType();

        return $this->createForm($form, $resource, array(
            'field_type' => $resource->getType(),
        ));
    }
}
