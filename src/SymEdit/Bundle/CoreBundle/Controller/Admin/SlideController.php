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

use Symfony\Component\HttpFoundation\Request;
use SymEdit\Bundle\CoreBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SymEdit\Bundle\CoreBundle\Model\Slide;
use SymEdit\Bundle\CoreBundle\Form\SlideType;

/**
 * Slide controller.
 *
 * @Route("/image/slider")
 */
class SlideController extends Controller
{
    /**
     * Displays a form to create a new Slide entity.
     *
     * @Route("/{slider_id}/slide/new", name="admin_image_slider_slide_new")
     * @Template()
     */
    public function newAction($slider_id)
    {
        $entity = new Slide();
        $form   = $this->createForm(new SlideType(), $entity);

        return array(
            'slider_id' => $slider_id,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Slide entity.
     *
     * @Route("/{slider_id}/slide/create", name="admin_image_slider_slide_create")
     * @Method("POST")
     * @Template("SymEditBundle:Admin/Slide:new.html.twig")
     */
    public function createAction($slider_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $slider = $em->getRepository('SymEdit\Bundle\CoreBundle\Model\Slider')->find($slider_id);

        if(!$slider){
            throw $this->createNotFoundException('Could not find slider');
        }

        $entity  = new Slide();
        $entity->setSlider($slider);
        $form = $this->createForm(new SlideType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('notice', 'New Slide Created');

            return $this->redirect($this->generateUrl('admin_image_slider_update', array('id' => $slider_id)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Slide entity.
     *
     * @Route("/slide/{id}/edit", name="admin_image_slider_slide_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SymEdit\Bundle\CoreBundle\Model\Slide')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slide entity.');
        }

        $editForm = $this->createForm(new SlideType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Slide entity.
     *
     * @Route("/slide/{id}/update", name="admin_image_slider_slide_update")
     * @Method("POST")
     * @Template("SymEditBundle:Admin/Slide:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SymEdit\Bundle\CoreBundle\Model\Slide')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slide entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SlideType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('notice', 'Slide Updated');

            return $this->redirect($this->generateUrl('admin_image_slider_slide_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Slide entity.
     *
     * @Route("/slide/{id}/delete", name="admin_image_slider_slide_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SymEdit\Bundle\CoreBundle\Model\Slide')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Slide entity.');
            }

            $this->addFlash('notice', 'Slide Removed');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_image_slider'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
