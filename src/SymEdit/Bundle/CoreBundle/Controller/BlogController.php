<?php

namespace SymEdit\Bundle\CoreBundle\Controller;

use Isometriks\Bundle\SitemapBundle\Annotation\Sitemap;
use SymEdit\Bundle\CoreBundle\Annotation\PageController as Bind;
use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\PostEvent;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use SymEdit\Bundle\CoreBundle\Model\Post;

class BlogController extends Controller
{
    /**
     * @Sitemap()
     */
    public function indexAction(Request $request, $_format, $page = null)
    {
        $postRepository = $this->getPostRepository();

        $criteria = array(
            'status' => Post::PUBLISHED,
        );

        $sorting = array(
            'createdAt' => 'DESC',
        );

        $posts = $postRepository->createPaginator($criteria, $sorting);
        $posts->setMaxPerPage($this->getMaxPosts());

        $template = $_format === 'xml' ? 'feed.xml.twig' : 'index.html.twig';

        return $this->render(sprintf('@SymEdit/Blog/%s', $template), array(
            'posts' => $posts,
        ));
    }

    /**
     * @Sitemap(params={"slug"="getSlug"}, entity="SymEdit\Bundle\CoreBundle\Model\Post")
     */
    public function slugViewAction($slug, Request $request)
    {
        $post = $this->getPostRepository()->findOneBySlug($slug);

        if (!$post) {
            throw $this->createNotFoundException(sprintf('Post with slug "%s" not found.', $slug));
        }

        /**
         * Dispatch post view event before cache kicks in so the event still fires
         */
        $event = new PostEvent($post, $request);
        $this->get('event_dispatcher')->dispatch(Events::POST_VIEW, $event);

        $response = $this->createResponse($post->getUpdatedAt());

        if ($response->isNotModified($request)) {
            return $response;
        }

        /**
         * Add Breadcrumbs
         */
        $this->addBreadcrumb($post->getTitle());

        return $this->render('@SymEdit/Blog/single.html.twig', array(
            'Post' => $post,
        ), $response);
    }

    public function previewAction($slug)
    {
        $context = $this->get('security.context');

        if (!$context->isGranted('ROLE_ADMIN')) {
            throw $this->createNotFoundException('No preview available');
        }

        $postManager = $this->getPostRepository();
        $postManager->disableStatusFilter();
        $post = $postManager->findPostBySlug($slug);

        if (!$post) {
            throw $this->createNotFoundException(sprintf('Post with slug "%s" not found.', $slug));
        }

        return $this->render('@SymEdit/Blog/single.html.twig', array(
            'Post' => $post,
            'SEO' => $post->getSeo(),
        ));
    }

    /**
     * @Sitemap(params={"slug"="getSlug"}, entity="SymEdit\Bundle\CoreBundle\Model\Category")
     *
     * @TODO: Move seo stuff to a listenere that listens for category.view etc.
     */
    public function categoryViewAction($slug, Request $request, $_format, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('SymEdit\Bundle\CoreBundle\Model\Category')->findOneBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException(sprintf('Category with slug "%s" not found.', $slug));
        }

        /**
         * Set SEO to use category
         */
        $this->getSeo()->setSubject($category);

        $query = $em->createQueryBuilder()
                ->select('p')
                ->from('SymEdit\Bundle\CoreBundle\Model\Post', 'p')
                ->join('p.categories', 'c')
                ->where(':catId MEMBER OF p.categories')
                ->orderBy('p.createdAt', 'DESC')
                ->setParameter('catId', $category->getId())
                ->getQuery();

        $paginator = $this->getPaginator($query, $page, 'blog_category_view');
        $paginator->setParam('slug', $slug);

        $latest = $paginator->current();

        $modified = !$latest ? new \DateTime() : $latest->getUpdatedAt();
        $response = $this->createResponse($modified);

        /**
         * If not modified return 304
         */
        if ($response->isNotModified($request)) {
            return $response;
        }

        /**
         * Add breadcrumbs
         */
        $this->addBreadcrumb($category->getTitle(), 'blog_category_view', array(
            'slug' => $category->getSlug(),
        ));

        $template = $_format === 'xml' ? 'feed.xml.twig' : 'category.html.twig';

        return $this->render(sprintf('@SymEdit/Blog/%s', $template), array(
            'Category' => $category,
            'Posts' => $paginator,
            'modified' => $modified,
        ), $response);
    }

    public function authorViewAction($username)
    {
        $em = $this->getDoctrine()->getManager();

        $user_manager = $this->container->get('fos_user.user_manager');
        $user = $user_manager->findUserBy(array('username' => $username));

        $query = $em->createQueryBuilder()
                ->select('p')
                ->from('SymEdit\Bundle\CoreBundle\Model\Post', 'p')
                ->join('p.author', 'a')
                ->where('a.username = :username')
                ->setParameter('username', $username)
                ->getQuery()
                ->setMaxResults($this->getMaxPosts());

        /**
         * Add Breadcrumbs
         */
        $this->addBreadcrumb($user->getProfile()->getFullname());

        return $this->render('@SymEdit/Blog/author.html.twig', array(
            'Posts' => $query->getResult(),
            'Author' => $user,
        ));
    }

    /**
     * @return RepositoryInterface
     */
    protected function getPostRepository()
    {
        return $this->get('symedit.repository.post');
    }

    /**
     * @return SlidingPagination
     */
    private function getPaginator($query, $page = 1, $route = null)
    {
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, $page, $this->getMaxPosts()
        );

        if($route !== null) {
            $pagination->setUsedRoute($route);
        }

        return $pagination;
    }

    private function getMaxPosts()
    {
        $settings = $this->getSettings();
        $max = 4;

        if ($settings->has('blog.max_posts')) {
            $max = $settings->get('blog.max_posts');
        }

        return $max;
    }
}
