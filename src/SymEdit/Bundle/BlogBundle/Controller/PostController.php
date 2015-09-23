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

use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PostController extends ResourceController
{
    public function showPublishedAction(Request $request)
    {
        $post = $this->findOr404($request);

        if (!$post->isPublished()) {
            throw $this->createNotFoundException('Post not published');
        }

        return $this->showAction($request);
    }

    public function previewAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->showAction($request);
        }

        throw new AccessDeniedException('Cannot view preview unless logged in');
    }

    public function showCategoryAction(Request $request, $slug)
    {
        $category = $this->get('symedit.repository.category')->findOneBy(array(
            'slug' => $slug,
        ));

        if ($category === null) {
            throw $this->createNotFoundException(sprintf('Category with slug "%s" not found', $category));
        }

        $config = $this->getConfiguration();
        $paginator = $this->getRepository()->getCategoryPaginator($category)
            ->setMaxPerPage($config->getPaginationMaxPerPage())
            ->setCurrentPage($request->get('page', 1), true, true)
        ;

        $view = $this
            ->view()
            ->setTemplate($config->getTemplate('index.html'))
            ->setTemplateVar('category')
            ->setData(array(
                'category' => $category,
                'posts' => $paginator,
            ));

        return $this->handleView($view);
    }
}
