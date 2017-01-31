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

use FOS\RestBundle\View\View;
use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

class FormElementController extends ResourceController
{
    public function chooseAction(Request $request, $formId)
    {
        $types = $this->get('symedit_form_builder.builder_registry')->getTypes();
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $view = View::create()
            ->setTemplate($configuration->getTemplate('@SymEdit/Admin/FormElement/choose.html.twig'))
            ->setData([
                'formId' => $formId,
                'types' => $types,
            ])
        ;

        return $this->viewHandler->handle($configuration, $view);
    }
}
