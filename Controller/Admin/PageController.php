<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use Isometriks\Bundle\SymEditBundle\Event\Events;
use Isometriks\Bundle\SymEditBundle\Event\PageEvent;
use Isometriks\Bundle\SymEditBundle\Form\PageReorderType;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Isometriks\Bundle\SymEditBundle\Model\PageManagerInterface;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;

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
     * @Method("GET")
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
        $page = $this->getPageManager()->createPage();
        $form   = $this->createCreateForm($page);

        return array(
            'entity' => $page,
            'form'   => $form->createView(),
            'action' => 'create',
        );
    }

    /**
     * @param PageInterface $page
     * @return FormInterface
     */
    private function createCreateForm(PageInterface $page)
    {
        return $this->createForm('symedit_page', $page, array(
            'action' => $this->generateUrl('admin_page_create'),
            'method' => 'POST',
        ));
    }

    /**
     * Creates a new Page entity.
     *
     * @Route("/", name="admin_page_create")
     * @Method("POST")
     * @Template("@SymEdit/Admin/Page/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $pageManager = $this->getPageManager();
        $page = $pageManager->createPage();
        $form   = $this->createCreateForm($page);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $pageManager->updatePage($page);
            $this->addFlash('notice', 'Page Created');

            $event = new PageEvent($page, $request);
            $this->get('event_dispatcher')->dispatch(Events::PAGE_CREATED, $event);

            return $this->redirectEdit($request, $page);
        }

        return array(
            'entity' => $page,
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
        $page = $this->getPageManager()->find($id);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createEditForm($page);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $page,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'action'      => 'update',
        );
    }

    private function createEditForm(PageInterface $page)
    {
        return $this->createForm('symedit_page', $page, array(
            'action' => $this->generateUrl('admin_page_update', array('id' => $page->getId())),
            'method' => 'PUT',
        ));
    }

    /**
     * Edits an existing Page entity.
     *
     * @Route("/{id}", name="admin_page_update")
     * @Method("PUT")
     * @Template("@SymEdit/Admin/Page/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $pageManager = $this->getPageManager();
        $entity = $pageManager->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
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
     * @param PageInterface $page
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
     * @Route("/{id}", name="admin_page_delete")
     * @Method("DELETE")
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

                return $this->redirect($this->generateUrl('admin_page_edit', array('id' => $entity->getId())));
            }

            $pageManager->deletePage($entity);
        }

        return $this->redirect($this->generateUrl('admin_page'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->setAction($this->generateUrl('admin_page_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @return PageManagerInterface $pageManager
     */
    private function getPageManager()
    {
        return $this->get('isometriks_symedit.page_manager');
    }
}
