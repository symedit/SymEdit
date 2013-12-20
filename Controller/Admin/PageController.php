<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Isometriks\Bundle\SymEditBundle\Form\PageReorderType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Page controller.
 *
 * @PreAuthorize("hasRole('ROLE_ADMIN_PAGE')")
 */
class PageController extends ResourceController
{
    /**
     * Lists all Page entities.
     */
    public function indexAction(Request $request)
    {
        $pageRepository = $this->getRepository();
        $root = $pageRepository->findOneBy(array('root' => true));

        $reorderForm = $this->createForm(new PageReorderType(), null, array('render' => true));

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Page/index.html.twig')
            ->setData(array(
                'root' => $root,
                'form' => $reorderForm->createView(),
            ));

        return $this->handleView($view);
    }

    public function reorderAction()
    {
        $reorder_form = $this->createForm(new PageReorderType());
        $reorder_form->handleRequest($this->getRequest());
        $status = false;

        if($reorder_form->isValid()){
            $status = true;
            $data = $reorder_form->getData();
            $repository = $this->getRepository();
            $manager = $this->getManager();

            foreach($data['pair'] as $id=>$order){
                if(!$entity = $repository->find($id)){
                    throw $this->createNotFoundException('Sorting entity not found');
                }

                $entity->setPageOrder($order);
                $manager->persist($entity);
            }

            $manager->flush();
        }


        return new JsonResponse(array(
            'status' => $status,
        ));
    }


    /**
     * Deletes a Page entity.
     *

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
    }*/
}
