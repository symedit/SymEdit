<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Isometriks\Bundle\SymEditBundle\Form\PageReorderType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
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
        $root = $pageRepository->findRoot();

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
        $reorderForm = $this->createForm(new PageReorderType());
        $reorderForm->handleRequest($this->getRequest());
        $status = false;

        if($reorderForm->isValid()){
            $status = true;
            $data = $reorderForm->getData();
            $repository = $this->getRepository();
            $manager = $this->getManager();

            foreach ($data['pair'] as $id=>$order) {
                if (!$entity = $repository->find($id)) {
                    throw $this->createNotFoundException('Sorting entity not found');
                }

                $entity->setPageOrder($order);
                $manager->persist($entity);
            }

            $manager->flush();
        }

        $view = $this->view()
            ->setFormat('json')
            ->setTemplateVar('status')
            ->setData(array(
                'status' => $status
            ));

        return $this->handleView($view);
    }
}
