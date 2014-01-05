<?php

namespace SymEdit\Bundle\CoreBundle\Controller\Admin;

use SymEdit\Bundle\CoreBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/stylizer")
 */
class StylizerController extends Controller
{
    /**
     * @Route("/", name="admin_stylizer")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        /**
         * Stylizer Bundle was not added, so this page shouldn't exist.
         */
        if(!$this->has('symedit_stylizer.stylizer')){
            throw $this->createNotFoundException();
        }

        $stylizer = $this->get('symedit_stylizer.stylizer');
        $form = $this->createForm('styles', $stylizer);

        if($request->getMethod() === 'POST'){

            $form->handleRequest($request);

            if($form->isValid()){

                $stylizer->save();

                if($request->request->has('dump')){
                    $stylizer->dump();

                    $this->addFlash('notice', 'Styles saved and dumped');
                } else {
                    $this->addFlash('notice', 'Styles Saved');
                }
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }
}