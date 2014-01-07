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

use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
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
        $event = new ResourceEvent($page);
        $this->get('event_dispatcher')->dispatch(Events::PAGE_VIEW, $event);

        /**
         * Check for template
         */
        if (($template = $page->getTemplate()) === null) {
            throw new \Exception('Page does not have a template, cannot render');
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
