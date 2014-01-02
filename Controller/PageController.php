<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Isometriks\Bundle\SymEditBundle\Event\Events;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\HttpFoundation\Request;

class PageController extends FOSRestController
{
    public function showAction(Request $request)
    {
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
}
