<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Isometriks\Bundle\SymEditBundle\Model\Category;
use Isometriks\Bundle\SymEditBundle\Model\CategoryInterface;
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
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $root = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Category')->findRoot();

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
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    private function createCreateForm(CategoryInterface $category)
    {
        return $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('admin_blog_category_create'),
            'method' => 'POST',
        ));
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/", name="admin_blog_category_create")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Category:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Category();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->addFlash('notice', 'Category Created');

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
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    private function createEditForm(CategoryInterface $category)
    {
        return $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('admin_blog_category_update', array('id' => $category->getId())),
            'method' => 'PUT',
        ));
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}", name="admin_blog_category_update")
     * @Method("PUT")
     * @Template("IsometriksSymEditBundle:Admin/Category:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setUpdated();
            $em->persist($entity);
            $em->flush();

            $this->addFlash('notice', 'Category Updated');

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
     * @Route("/{id}", name="admin_blog_category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->addFlash('notice', 'Category Deleted');
        }

        return $this->redirect($this->generateUrl('admin_blog_category'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->setAction($this->generateUrl('admin_blog_category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
