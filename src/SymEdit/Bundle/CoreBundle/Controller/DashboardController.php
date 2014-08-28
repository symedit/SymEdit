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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Dashboard controller.
 */
class DashboardController extends Controller
{
    /**
     * Lists all Page entities.
     *
     * @Route("/", name="admin_dashboard")
     */
    public function indexAction()
    {
        $reporter = $this->get('symedit_analytics.reporter');

        $popularPages = $reporter->runReport('popular_pages');
        $popularPosts = $reporter->runReport('popular_posts');

        return $this->render('@SymEdit/Admin/Dashboard/index.html.twig', array(
            'popularPages' => $popularPages,
            'popularPosts' => $popularPosts,
        ));
    }
}
