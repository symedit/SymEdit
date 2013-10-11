<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Isometriks\Bundle\SymEditBundle\Model\Image;
use Isometriks\Bundle\SymEditBundle\Form\ImageType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * Image controller.
 *
 * @Route("/image")
 * @PreAuthorize("hasRole('ROLE_ADMIN_IMAGE')")
 */
class ImageController extends Controller
{
    /**
     * Lists all Image entities.
     *
     * @Route("/", name="admin_image")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Image')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Image entity.
     *
     * @Route("/new", name="admin_image_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Image();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Image entity.
     *
     * @Route("/{id}", name="admin_image_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    private function createCreateForm(Image $image)
    {
        return $this->createForm(new ImageType(), $image, array(
            'action' => $this->generateUrl('admin_image_create'),
            'method' => 'POST',
        ));
    }

    /**
     * Creates a new Image entity.
     *
     * @Route("/create", name="admin_image_create")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Image:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Image();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->addFlash('notice', 'Image Uploaded');

            return $this->redirect($this->generateUrl('admin_image'));
        }

        $this->get('session')->getFlashBag()->add('error', 'Error Uploading Image');

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Image entity.
     *
     * @Route("/{id}/edit", name="admin_image_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    private function createEditForm(Image $image)
    {
        return $this->createForm(new ImageType(), $image, array(
            'show_image' => false,
            'action' => $this->generateUrl('admin_image_update', array('id' => $image->getId())),
            'method' => 'PUT',
        ));
    }

    /**
     * Edits an existing Image entity.
     *
     * @Route("/{id}/update", name="admin_image_update")
     * @Method("PUT")
     * @Template("IsometriksSymEditBundle:Admin/Image:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Image Updated');

            return $this->redirect($this->generateUrl('admin_image_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/{id}/delete", name="admin_image_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Image')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Image entity.');
            }

            try {
                $em->remove($entity);
                $em->flush();
                $this->addFlash('notice', 'Image Removed');
            } catch(\Exception $e) {
                $this->addFlash('error', 'There was an error removing the image. Make sure it is not used in a Post or a Slider.');
            }
        }

        return $this->redirect($this->generateUrl('admin_image'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->setAction($this->generateUrl('admin_image_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/images.{_format}", defaults={"_format"="json"}, name="admin_image_json")
     */
    public function jsonAction()
    {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Image')->findAll();

        $manip = $this->get('isometriks_media.util.image_manipulator');

        $out = array();

        foreach($images as $image){
            $out[] = array(
                'thumb' => $manip->constrain($image->getWebPath(), array('w' => 234)),
                'image' => $image->getWebPath(),
            );
        }

        return new JsonResponse($out);
    }

    /**
     * @Route("/quick-upload", name="admin_image_quick_upload")
     */
    public function quickUploadAction(Request $request)
    {
        $file = $request->files->get('file');
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $entity = new Image();
        $entity->setFile($file);
        $entity->setName($name);

        $em = $this->getDoctrine()->getManager();

        try {
            $em->persist($entity);
            $em->flush();

            return new JsonResponse(array(
                'filelink' => $entity->getWebPath(),
            ));

        } catch (\Exception $ex) {

            return new JsonResponse(array(
                'error' => 'Error uploading, try renaming your image file.',
            ));

        }
    }
}
