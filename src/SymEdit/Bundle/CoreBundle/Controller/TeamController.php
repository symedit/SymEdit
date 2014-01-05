<?php

namespace SymEdit\Bundle\CoreBundle\Controller;

use Isometriks\Bundle\SitemapBundle\Annotation\Sitemap;

class TeamController extends Controller
{
    /**
     * @Sitemap()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userClass = $this->container->getParameter('fos_user.model.user.class');

        $query = $em->createQueryBuilder()
                    ->select('u')
                    ->from($userClass, 'u')
                    ->join('u.profile', 'p')
                    ->where('u.admin = true')
                    ->orderBy('p.lastName, p.firstName')
                    ->getQuery();

        $result = $query->getResult();

        $users = array_filter($result, function($user){
            return $user->getProfile()->getDisplay();
        });

        return $this->render('@SymEdit/Team/index.html.twig', array(
            'users' => $users,
        ));
    }

    public function viewAction($slug)
    {
        $profile = $this->getUserManager()->findAdminProfileBy(array(
            'slug' => $slug,
        ));

        if(!$profile) {
            throw $this->createNotFoundException(sprintf('Could not find user with slug "%s".', $slug));
        }

        /**
         * Add Breadcrumbs
         */
        $this->addBreadcrumb($profile->getFullname());

        return $this->render('@SymEdit/Team/view.html.twig', array(
            'user' => $profile->getUser(),
        ));
    }
}
