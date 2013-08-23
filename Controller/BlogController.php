<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Isometriks\Bundle\SymEditBundle\Annotation\PageController as Bind;
use Isometriks\Bundle\SymEditBundle\Entity\Post;
use Isometriks\Bundle\SymEditBundle\Model\BreadcrumbsInterface;
use Isometriks\Bundle\SitemapBundle\Annotation\Sitemap;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Bind(name="symedit-blog")
 */
class BlogController extends Controller
{
    /**
     * @Route("/", name="blog", defaults={"_format"="html"})
     * @Route("/feed.xml", name="blog_rss", defaults={"_format"="xml"})
     * @Route("/archive/{page}", name="blog_archive", requirements={"slug"=".*?", "page"="\d+"}, defaults={"page"=1, "_format"="html"})
     * @Sitemap()
     */
    public function indexAction(Request $request, $_format, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('IsometriksSymEditBundle:Post');

        $modified = $repo->getRecentQueryBuilder()
                         ->select('MAX(p.updatedAt) as modified')
                         ->getQuery()
                         ->getSingleScalarResult();

        $modifiedDate = new \DateTime($modified);
        $response = $this->createResponse($modifiedDate);

        if ($response->isNotModified($request)) {
            return $response;
        }

        $paginator = $this->getPaginator($repo->getRecentQuery(), $page, 'blog_archive');

        $template = $_format === 'xml' ? 'feed.xml.twig' : 'index.html.twig';

        return $this->render(sprintf('@SymEdit/Blog/%s', $template), array(
            'Posts' => $paginator,
            'modified' => $modifiedDate,
        ), $response);
    }

    /**
     * @Route("/{slug}", name="blog_slug_view", requirements={"slug"="[a-z0-9_-]+"})
     * @Sitemap(params={"slug"="getSlug"}, entity="IsometriksSymEditBundle:Post")
     */
    public function slugViewAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('IsometriksSymEditBundle:Post')->findOneBySlug($slug);

        if (!$post) {
            throw $this->createNotFoundException(sprintf('Post with slug "%s" not found.', $slug));
        }

        $response = $this->createResponse($post->getUpdatedAt());

        if ($response->isNotModified($request)) {
            return $response;
        }

        /**
         * Add Breadcrumbs
         */
        $this->addBreadcrumb($post->getTitle(), 'blog_slug_view', array(
            'slug' => $post->getSlug(),
        ));

        return $this->render('@SymEdit/Blog/single.html.twig', array(
            'Post' => $post,
            'SEO' => $post->getSeo(),
        ), $response);
    }

    /**
     * @Route("/preview/{slug}", name="blog_preview")
     */
    public function previewAction($slug)
    {
        $context = $this->get('security.context');

        if (!$context->isGranted('ROLE_ADMIN')) {
            throw $this->createNotFoundException('No preview available');
        }

        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('post_published');

        $post = $em->getRepository('IsometriksSymEditBundle:Post')->findOneBySlug($slug);

        if (!$post) {
            throw $this->createNotFoundException(sprintf('Post with slug "%s" not found.', $slug));
        }

        return $this->render('@SymEdit/Blog/single.html.twig', array(
            'Post' => $post,
            'SEO' => $post->getSeo(),
        ));
    }

    /**
     * @Route("/category/{slug}/feed.xml", defaults={"page"=1, "_format"="xml"}, name="blog_category_rss")
     * @Route("/category/{slug}/{page}", defaults={"page"=1, "_format"="html"}, requirements={"slug"=".*?", "page"="\d+"}, name="blog_category_view")
     *
     * @Sitemap(params={"slug"="getSlug"}, entity="IsometriksSymEditBundle:Category")
     */
    public function categoryViewAction($slug, Request $request, $_format, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('IsometriksSymEditBundle:Category')->findOneBySlug($slug);

        if (!$category) {
            throw $this->createNotFoundException(sprintf('Category with slug "%s" not found.', $slug));
        }

        $query = $em->createQueryBuilder()
                ->select('p')
                ->from('IsometriksSymEditBundle:Post', 'p')
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
            'SEO' => $category->getSeo(),
            'Posts' => $paginator,
            'modified' => $modified,
        ), $response);
    }

    /**
     * @Route("/user/{username}", name="blog_author_view")
     */
    public function authorViewAction($username)
    {
        $em = $this->getDoctrine()->getManager();

        $user_manager = $this->container->get('fos_user.user_manager');
        $user = $user_manager->findUserBy(array('username' => $username));

        $query = $em->createQueryBuilder()
                ->select('p')
                ->from('IsometriksSymEditBundle:Post', 'p')
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
     * @return \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination
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