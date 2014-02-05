<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Controller\Admin;

use SymEdit\Bundle\CoreBundle\Controller\Controller;
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
        $pageManager = $this->get('symedit.repository.page');
        $postManager = $this->get('symedit.repository.post');

        return $this->render('@SymEdit/Admin/Dashboard/index.html.twig', array(
            'popularPages' => $pageManager->findPopular(5),
            'popularPosts' => $postManager->findPopular(5),
        ));
    }
}
