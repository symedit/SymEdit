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

use FOS\RestBundle\View\View;
use Sylius\Component\Resource\ResourceActions;
use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PostController extends ResourceController
{
    public function showPublishedAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $post = $this->findOr404($configuration);

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
        $category = $this->get('symedit.repository.category')->findOneBy([
            'slug' => $slug,
        ]);

        if ($category === null) {
            throw $this->createNotFoundException(sprintf('Category with slug "%s" not found', $category));
        }

        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $paginator = $this->repository->getCategoryPaginator($category)
            ->setMaxPerPage($configuration->getPaginationMaxPerPage())
            ->setCurrentPage($request->get('page', 1), true, true)
        ;

        $view = View::create()
            ->setTemplate($configuration->getTemplate('index.html'))
            ->setTemplateVar('category')
            ->setData([
                'category' => $category,
                'posts' => $paginator,
            ]);

        return $this->viewHandler->handle($configuration, $view);
    }

    public function rssAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::INDEX);
        $resources = $this->resourcesCollectionProvider->get($configuration, $this->repository);

        $view = View::create($resources);
        $view
            ->setTemplate($configuration->getTemplate(ResourceActions::INDEX . '.html'))
            ->setTemplateVar($this->metadata->getPluralName())
            ->setData([
                'configuration' => $configuration,
                'metadata' => $this->metadata,
                'resources' => $resources,
                $this->metadata->getPluralName() => $resources,
            ])
        ;

        return $this->viewHandler->handle($configuration, $view);
    }
}
