<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Dashboard controller.
 */
class DashboardController extends Controller {

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="admin_dashboard")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
