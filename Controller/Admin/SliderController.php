<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Isometriks\Bundle\SymEditBundle\Entity\Slider;
use Isometriks\Bundle\SymEditBundle\Form\SliderType;

/**
 * Slider controller.
 *
 * @Route("/image/slider")
 */
class SliderController extends Controller
{
    /**
     * Lists all Slider entities.
     *
     * @Route("/", name="admin_image_slider")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IsometriksSymEditBundle:Slider')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Slider entity.
     *
     * @Route("/new", name="admin_image_slider_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Slider();
        $form   = $this->createForm(new SliderType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Slider entity.
     *
     * @Route("/create", name="admin_image_slider_create")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Slider:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Slider();
        $form = $this->createForm(new SliderType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Slider Created'); 
            
            return $this->redirect($this->generateUrl('admin_image_slider_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Slider entity.
     *
     * @Route("/{id}/edit", name="admin_image_slider_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IsometriksSymEditBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $editForm = $this->createForm(new SliderType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Slider entity.
     *
     * @Route("/{id}/update", name="admin_image_slider_update")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Slider:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IsometriksSymEditBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SliderType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_image_slider_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Slider entity.
     *
     * @Route("/{id}/delete", name="admin_image_slider_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IsometriksSymEditBundle:Slider')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Slider entity.');
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
