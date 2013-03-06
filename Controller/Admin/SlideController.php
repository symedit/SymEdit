<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Isometriks\Bundle\SymEditBundle\Entity\Slide;
use Isometriks\Bundle\SymEditBundle\Form\SlideType;

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
     * @Template("IsometriksSymEditBundle:Admin/Slide:new.html.twig")
     */
    public function createAction($slider_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $slider = $em->getRepository('IsometriksSymEditBundle:Slider')->find($slider_id); 
        
        if(!$slider){
            throw $this->createNotFoundException('Could not find slider'); 
        }
        
        $entity  = new Slide();
        $entity->setSlider($slider); 
        $form = $this->createForm(new SlideType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'New Slide Created'); 
            
            return $this->redirect($this->generateUrl('admin_image_slider_edit', array('id' => $slider_id)));
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

        $entity = $em->getRepository('IsometriksSymEditBundle:Slide')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slide entity.');
        }

        $editForm = $this->createForm(new SlideType($entity->getImage()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Slide entity.
     *
     * @Route("/slide/{id}/update", name="admin_image_slider_slide_update")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Slide:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IsometriksSymEditBundle:Slide')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slide entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SlideType($entity->getImage()), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_image_slider_slide_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IsometriksSymEditBundle:Slide')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Slide entity.');
            }

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
