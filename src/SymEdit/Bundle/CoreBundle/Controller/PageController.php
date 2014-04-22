<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Controller;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PageController extends ResourceController
{
    public function showAction()
    {
        $request = $this->getRequest();

        /* @var $page PageInterface */
        $page = $request->get('_page');

        /**
         * Dispatch page view event
         */
        $this->dispatchEvent('view', $page);

        /**
         * Check for template
         */
        if (($template = $page->getTemplate()) === null) {
            $template = 'base.html.twig';
        }

        $view = $this
            ->view()
            ->setTemplateVar('Page')
            ->setData($page)
            ->setTemplate(sprintf('@SymEdit/Page/%s', $template));

        $response = $view
            ->getResponse()
            ->setLastModified($page->getUpdatedAt());

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $this->handleView($view);
    }

   /**
     * Lists all Page entities.
     */
    public function indexAction(Request $request)
    {
        $config = $this->getConfiguration();

        if ($config->isApiRequest()) {
            return parent::indexAction($request);
        }

        $root = $this->getRepository()->findRoot();
        $reorderForm = $this->createForm('symedit_page_reorder', null, array('render' => true));

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
        $reorderForm = $this->createForm('symedit_page_reorder');
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

    public function jsonAction()
    {
        $pages = $this->getRepository()->findCMSPages(true, array(
            'path' => 'ASC',
        ));

        $out = array();

        foreach ($pages as $page) {
            $out[] = array(
                'name' => $page->getTitle(),
                'url' => $this->generateUrl($page->getRoute()),
            );
        }

        return new JsonResponse($out);
    }
}
