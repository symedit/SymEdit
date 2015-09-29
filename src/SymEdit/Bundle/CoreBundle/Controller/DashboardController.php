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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        return $this->render('@SymEdit/Admin/Dashboard/index.html.twig');
    }
}
