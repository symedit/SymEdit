<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Isometriks\Bundle\SymEditBundle\Entity\Page; 
use Isometriks\Bundle\SymEditBundle\Form\PageType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize; 
use Isometriks\Bundle\SymEditBundle\Form\PageReorderType; 

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
        $em = $this->getDoctrine()->getManager();
        $root = $em->getRepository('IsometriksSymEditBundle:Page')->findRoot();
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
        $reorder_form->bind($this->getRequest()); 
        $status = false; 
        
        if($reorder_form->isValid()){
            $status = true; 
            $data = $reorder_form->getData(); 
            $em = $this->getDoctrine()->getManager(); 
            $repo = $em->getRepository('IsometriksSymEditBundle:Page'); 
            
            foreach($data['pair'] as $id=>$order){
                if(!$entity = $repo->find($id)){
                    throw $this->createNotFoundException('Sorting entity not found'); 
                }
                
                $entity->setPageOrder($order); 
                $em->persist($entity); 
            }
            
            $em->flush(); 
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
        $entity = new Page();
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
        $entity  = new Page();
        $form = $this->createForm(new PageType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Page Created'); 
            
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IsometriksSymEditBundle:Page')->find($id);

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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IsometriksSymEditBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PageType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Isometriks\Bundle\SymEditBundle\Entity\Page $page
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
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IsometriksSymEditBundle:Page')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Page entity.');
            }
            
            // Don't delete the homepage or root!
            if($entity->getHomepage() || $entity->getRoot()){
                $this->get('session')->getFlashBag()->add('error', 'Cannot delete this page.');
                
                return $this->redirect($this->generateUrl('admin_page'));  
            }

            $em->remove($entity);
            $em->flush();
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
}
