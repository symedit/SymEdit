<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use Isometriks\Bundle\SymEditBundle\Entity\Page;
use Isometriks\Bundle\SymEditBundle\Form\PageReorderType;
use Isometriks\Bundle\SymEditBundle\Form\PageType;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Isometriks\Bundle\SymEditBundle\Model\PageManagerInterface;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Page controller.
 *
 * @Route("/page")
 * @PreAuthorize("hasRole('ROLE_ADMIN_PAGE')")
 */
class PageController extends Controller
{
    /**
     * Lists all Page entities.
     *
     * @Route("/", name="admin_page")
     * @Template()
     */
    public function indexAction()
    {
        $pageManager = $this->getPageManager();
        $root = $pageManager->findRoot();

        $reorder_form = $this->createForm(new PageReorderType(), null, array('render' => true));

        return array(
            'Root' => $root,
            'reorder_form' => $reorder_form->createView(),
        );
    }

    /**
     * @Route("/reorder", name="admin_page_reorder")
     */
    public function reorderAction()
    {
        $reorder_form = $this->createForm(new PageReorderType());
        $reorder_form->handleRequest($this->getRequest());
        $status = false;

        if($reorder_form->isValid()){
            $status = true;
            $data = $reorder_form->getData();
            $pageManager = $this->getPageManager();

            foreach($data['pair'] as $id=>$order){
                if(!$entity = $pageManager->find($id)){
                    throw $this->createNotFoundException('Sorting entity not found');
                }

                $entity->setPageOrder($order);
                $pageManager->updatePage($entity);
            }
        }

        return new JsonResponse(array(
            'status' => $status,
        ));
    }

    /**
     * Displays a form to create a new Page entity.
     *
     * @Route("/new", name="admin_page_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = $this->getPageManager()->createPage();
        $form   = $this->createForm(new PageType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'action' => 'create',
        );
    }

    /**
     * Creates a new Page entity.
     *
     * @Route("/create", name="admin_page_create")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Page:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $pageManager = $this->getPageManager();
        $entity = $pageManager->createPage();
        $form = $this->createForm(new PageType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $pageManager->updatePage($entity);
            $this->addFlash('notice', 'Page Created');

            return $this->redirectEdit($request, $entity);
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{id}/edit", name="admin_page_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->getPageManager()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createForm(new PageType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'action'      => 'update',
        );
    }

    /**
     * Edits an existing Page entity.
     *
     * @Route("/{id}/update", name="admin_page_update")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Page:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $pageManager = $this->getPageManager();
        $entity = $pageManager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PageType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $pageManager->updatePage($entity);
            $this->addFlash('notice', 'Page Updated');

            return $this->redirectEdit($request, $entity);
        }

        return array(
            'entity'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Keeping things DRY. Used to determine if the live_edit field was passed
     * from either a create form or an edit form. If it is, send the user to
     * the page instead.
     *
     * @param Request $request
     * @param Page $page
     * @return RedirectResponse
     */
    private function redirectEdit(Request $request, PageInterface $page)
    {
        if($request->request->has('live_edit')){
            $url = $this->generateUrl($page->getRoute());
        } else {
            $url = $this->generateUrl('admin_page_edit', array('id' => $page->getId()));
        }

        return $this->redirect($url);
    }

    /**
     * Deletes a Page entity.
     *
     * @Route("/{id}/delete", name="admin_page_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $pageManager = $this->getPageManager();
            $entity = $pageManager->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Page entity.');
            }

            // Don't delete the homepage or root!
            if($entity->getHomepage() || $entity->getRoot()){

                $this->addFlash('error', 'Cannot delete this page.');

                return $this->redirect($this->generateUrl('admin_page'));
            }

            $pageManager->deletePage($entity);
        }

        return $this->redirect($this->generateUrl('admin_page'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * @return PageManagerInterface $pageManager
     */
    private function getPageManager()
    {
        return $this->get('isometriks_symedit.page_manager');
    }
}
