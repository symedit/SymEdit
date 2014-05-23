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

use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PageController extends ResourceController
{
    public function showAction(Request $request)
    {
        /* @var $page PageInterface */
        $page = $request->get('_page');

        /**
         * Dispatch page view event
         */
        $this->domainManager->dispatchEvent('view', new ResourceEvent($page));

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
            ->setPublic()
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

        if ($reorderForm->isValid()) {
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
        $pages = $this->getRepository()->getRecursiveIterator();
        $out = array();

        foreach ($pages as $page) {
            $label = sprintf('%s %s',str_repeat('--', $page->getLevel()), $page->getTitle());

            $out[] = array(
                'name' => trim($label),
                'url' => sprintf('[link page-id=%d]', $page->getId()),
            );
        }

        return new JsonResponse($out);
    }
}
