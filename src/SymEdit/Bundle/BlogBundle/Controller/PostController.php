<?php

namespace SymEdit\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class PostController extends ResourceController
{
    public function getIndexView()
    {
        $config = $this->getConfiguration();
        $request = $this->getRequest();
        $criteria = $config->getCriteria();
        $sorting = $config->getSorting();

        $pluralName = $config->getPluralResourceName();
        $repository = $this->getRepository();

        if ($config->isPaginated()) {
            $resources = $this
                ->getResourceResolver()
                ->getResource($repository, $config, 'createPaginator', array($criteria, $sorting))
            ;

            $resources
                ->setCurrentPage($request->get('page', 1), true, true)
                ->setMaxPerPage($config->getPaginationMaxPerPage())
            ;
        } else {
            $resources = $this
                ->getResourceResolver()
                ->getResource($repository, $config, 'findBy', array($criteria, $sorting, $config->getLimit()))
            ;
        }

        return $this
            ->view()
            ->setTemplate($config->getTemplate('index.html'))
            ->setTemplateVar($pluralName)
            ->setData($resources)
        ;
    }

    /**
     * Get posts by an author
     */
    public function showAuthorAction(Request $request, $username)
    {
        $author = $this->get('symedit.repository.user')->findOneBy(array(
            'username' => $username,
        ));

        if ($author === null) {
            throw $this->createNotFoundException(sprintf('Author with username "%s" not found', $username));
        }

        $config = $this->getConfiguration();

        $view = $this->getIndexView();
        $view->setData(array(
            $config->getPluralResourceName() => $view->getData(),
            'author' => $author,
        ));

        return $this->handleView($view);
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
        $pluralName = $config->getPluralResourceName();

        $posts = $this->getRepository()->findByCategoryQueryBuilder($category);
        $paginator = $this
            ->getRepository()
            ->getPaginator($posts)
            ->setMaxPerPage($config->getPaginationMaxPerPage())
            ->setCurrentPage($request->get('page', 1));

        $view = $this
            ->view()
            ->setTemplate($config->getTemplate('index.html'))
            ->setTemplateVar($pluralName)
            ->setData(array(
                $pluralName => $paginator,
                'category' => $category,
            ));

        return $this->handleView($view);
    }
}