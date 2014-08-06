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
use SymEdit\Bundle\CoreBundle\Controller\Controller;
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
        /**
         * Stylizer Bundle was not added, so this page shouldn't exist.
         */
        if (!$this->has('symedit_stylizer.stylizer')) {
            throw $this->createNotFoundException();
        }

        $stylizer = $this->get('symedit_stylizer.stylizer');
        $form = $this->createForm('symedit_stylizer', $stylizer);

        if ($request->getMethod() === 'POST' && $form->handleRequest($request)->isValid()) {

            // Save Styles
            $stylizer->save();

            // Dump Styles
            if ($request->request->has('dump')) {
                $stylizer->dump();

                $this->addFlash('success', 'Styles saved and dumped');
            } else {
                $this->addFlash('success', 'Styles Saved');
            }
        }

        return $this->render('@SymEdit/Admin/Stylizer/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
