<?php

namespace SymEdit\Bundle\CoreBundle\Controller\Admin;

use SymEdit\Bundle\CoreBundle\Controller\Controller;
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
        $pageManager = $this->get('isometriks_symedit.repository.page');
        $postManager = $this->get('isometriks_symedit.repository.post');

        return array(
            'popularPages' => $pageManager->findPopular(5),
            'popularPosts' => $postManager->findPopular(5),
        );
    }
}
