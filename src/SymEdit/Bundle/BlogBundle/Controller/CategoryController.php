<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
