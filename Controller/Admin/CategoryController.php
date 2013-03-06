<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Isometriks\Bundle\SymEditBundle\Entity\Category;
use Isometriks\Bundle\SymEditBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/blog/category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_blog_category")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $root = $em->getRepository('IsometriksSymEditBundle:Category')->findRoot();

        return array(
            'RootCategory' => $root,
        );
    }


    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="admin_blog_category_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Category();
        $form   = $this->createForm(new CategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/create", name="admin_blog_category_create")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Category:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Category();
        $form = $this->createForm(new CategoryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Category Created'); 
            
            return $this->redirect($this->generateUrl('admin_blog_category_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="admin_blog_category_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IsometriksSymEditBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}/update", name="admin_blog_category_update")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Category:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IsometriksSymEditBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $entity->setUpdated(); 
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Category Updated'); 
            
            return $this->redirect($this->generateUrl('admin_blog_category_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="admin_blog_category_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IsometriksSymEditBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_blog_category'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
