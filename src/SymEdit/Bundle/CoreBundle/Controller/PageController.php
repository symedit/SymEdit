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
use Sylius\Component\Resource\ResourceActions;
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

        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $page);

        $view = View::create($page)
            ->setTemplateVar('Page')
            ->setData($page)
            ->setTemplate($template)
        ;

        return $this->viewHandler->handle($configuration, $view);
    }

    public function jsonAction()
    {
        $pages = $this->repository->getRecursiveIterator();
        $out = [];

        foreach ($pages as $page) {
            $label = sprintf('%s %s', str_repeat('--', $page->getLevel()), $page->getTitle());

            $out[] = [
                'name' => trim($label),
                'url' => sprintf('[link page-id=%d]', $page->getId()),
            ];
        }

        return new JsonResponse($out);
    }
}
