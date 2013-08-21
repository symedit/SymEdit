<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Isometriks\Bundle\SymEditBundle\Entity\Post;
use Isometriks\Bundle\SymEditBundle\Form\PostType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;


/**
 * Post controller.
 *
 * @Route("/blog")
 * @PreAuthorize("hasRole('ROLE_ADMIN_BLOG')")
 */
class PostController extends Controller
{

    /**
     * Lists all Post entities.
     *
     * @Route("/", name="admin_blog")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('post_published');

        $entities = $em->createQuery('SELECT p FROM IsometriksSymEditBundle:Post p ORDER BY p.createdAt DESC')
                       ->getResult();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Post entity.
     *
     * @Route("/new", name="admin_blog_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Post();
        $entity->setAuthor($this->getUser());
        $form   = $this->createForm('symedit_post', $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/create", name="admin_blog_create")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Post:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Post();
        $form = $this->createForm('symedit_post', $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Post Created');

            return $this->redirect($this->generateUrl('admin_blog_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="admin_blog_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('post_published');

        $entity = $em->getRepository('IsometriksSymEditBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createForm('symedit_post', $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Post entity.
     *
     * @Route("/{id}/update", name="admin_blog_update")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Post:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('post_published');

        $entity = $em->getRepository('IsometriksSymEditBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm('symedit_post', $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Post Updated');

            return $this->redirect($this->generateUrl('admin_blog_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}/delete", name="admin_blog_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getFilters()->disable('post_published');
            $entity = $em->getRepository('IsometriksSymEditBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_blog'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
