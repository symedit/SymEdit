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

        $response = $this->get('symedit.cache_manager')->getLastModifiedResponse($page->getUpdatedAt());
        $view->setResponse($response);

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

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Page/index.html.twig')
            ->setData(array(
                'root' => $root
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
