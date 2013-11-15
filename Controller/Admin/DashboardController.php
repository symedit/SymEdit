<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Dashboard controller.
 */
class DashboardController extends Controller
{
    /**
     * Lists all Page entities.
     *
     * @Route("/", name="admin_dashboard")
     * @Template()
     */
    public function indexAction()
    {
        $pageManager = $this->get('isometriks_symedit.page_manager');
        $postManager = $this->get('isometriks_symedit.post_manager');

        return array(
            'popularPages' => $pageManager->findPopular(5),
            'popularPosts' => $postManager->findPopular(5),
        );
    }
}
