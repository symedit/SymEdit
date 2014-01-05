<?php

namespace SymEdit\Bundle\BlogBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 */
class CategoryController extends ResourceController
{
    /**
     * Lists all Page entities.
     */
    public function indexAction(Request $request)
    {
        $rootCategory = $this->getRepository()->findRoot();

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Category/index.html.twig')
            ->setTemplateVar('root')
            ->setData($rootCategory);

        return $this->handleView($view);
    }
}
