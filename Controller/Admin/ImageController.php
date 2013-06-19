<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Isometriks\Bundle\SymEditBundle\Entity\Image;
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
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IsometriksSymEditBundle:Image')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Image entity.
     *
     * @Route("/{id}/show", name="admin_image_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IsometriksSymEditBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Image entity.
     *
     * @Route("/new", name="admin_image_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Image();
        $form   = $this->createForm(new ImageType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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
        $entity  = new Image();
        $form = $this->createForm(new ImageType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {         
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Image Uploaded'); 
            
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
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IsometriksSymEditBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $editForm = $this->createForm(new ImageType( $entity->getName() ), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Image entity.
     *
     * @Route("/{id}/update", name="admin_image_update")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Image:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IsometriksSymEditBundle:Image')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ImageType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Image Updated'); 
            
            return $this->redirect($this->generateUrl('admin_image_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/{id}/delete", name="admin_image_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IsometriksSymEditBundle:Image')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Image entity.');
            }

            $flashBag = $this->get('session')->getFlashBag(); 
            
            try {
                $em->remove($entity);
                $em->flush();
                $flashBag->add('notice', 'Image Removed'); 
            } catch(\Exception $e) {
                $flashBag->add('error', 'There was an error removing the image. Make sure it is not used in a Post or a Slider.'); 
            }
        }

        return $this->redirect($this->generateUrl('admin_image'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * @Route("/images.{_format}", defaults={"_format"="json"}, name="admin_image_json")
     */
    public function jsonAction()
    {
        $em = $this->getDoctrine()->getManager(); 
        $images = $em->getRepository('IsometriksSymEditBundle:Image')->findAll(); 
        
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
}
