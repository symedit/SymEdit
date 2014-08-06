<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Controller;

class TeamController extends Controller
{
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

        $users = array_filter($result, function ($user) {
            return $user->getProfile()->getDisplay();
        });

        return $this->render('@SymEdit/Team/index.html.twig', array(
            'users' => $users,
        ));
    }

    public function viewAction($slug)
    {
        $profile = $this->get('symedit.repository.admin_profile')->findOneBy(array(
            'slug' => $slug,
        ));

        if (!$profile) {
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
