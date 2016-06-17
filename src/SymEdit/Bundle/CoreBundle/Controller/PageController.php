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

use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
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

        /*
         * Check for template
         */
        if (($template = $page->getTemplate()) === null) {
            $template = '@Theme/Page/base.html.twig';
        }

        $view = View::create($page)
            ->setTemplateVar('Page')
            ->setData($page)
            ->setTemplate($template)
        ;

        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        return $this->viewHandler->handle($configuration, $view);
    }

    public function jsonAction()
    {
        $pages = $this->getRepository()->getRecursiveIterator();
        $out = array();

        foreach ($pages as $page) {
            $label = sprintf('%s %s', str_repeat('--', $page->getLevel()), $page->getTitle());

            $out[] = array(
                'name' => trim($label),
                'url' => sprintf('[link page-id=%d]', $page->getId()),
            );
        }

        return new JsonResponse($out);
    }

    public function findOr404(RequestConfiguration $configuration)
    {
        $request = $configuration->getRequest();

        if ($request->attributes->has('_page')) {
            $page = $request->attributes->get('_page');

            if ($page->getId() !== null) {
                return $page;
            }
        }

        return parent::findOr404($configuration);
    }
}
