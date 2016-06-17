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
use SymEdit\Bundle\StylizerBundle\Model\StyleManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/stylizer")
 */
class StylizerController extends Controller
{
    /**
     * @Route("/", name="admin_stylizer")
     */
    public function indexAction(Request $request)
    {
        $styles = $this->getStyleManager()->getStyles();
        $form = $this->createForm('symedit_stylizer', $styles);

        if ($request->getMethod() === 'POST' && $form->handleRequest($request)->isValid()) {
            // Save Styles
            $this->getStyleManager()->saveStyles($styles);

            // Dump Styles
            if ($request->request->has('dump')) {
                $this->getDumper()->dump();

                $this->addFlash('success', 'symedit.stylizer.save_and_dump');
            } else {
                $this->addFlash('success', 'symedit.stylizer.save');
            }
        }

        return $this->render('@SymEdit/Admin/Stylizer/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return StyleManager $manager
     */
    protected function getStyleManager()
    {
        return $this->get('symedit_stylizer.style_manager');
    }

    protected function getDumper()
    {
        return $this->get('symedit_stylizer.dumper');
    }
}
