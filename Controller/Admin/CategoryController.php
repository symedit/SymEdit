<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 * @PreAuthorize("hasRole('ROLE_ADMIN_BLOG')")
 */
class CategoryController extends ResourceController
{
    /**
     * Lists all Page entities.
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getRepository();
        $rootCategory = $repository->createNew();
        $roots = $repository->findBy(array('parent' => null));
        $rootCategory->setChildren($roots);

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Category/index.html.twig')
            ->setTemplateVar('root')
            ->setData($rootCategory);

        return $this->handleView($view);
    }
}
