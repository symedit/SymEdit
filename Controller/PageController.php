<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Isometriks\Bundle\SymEditBundle\Event\Events;
use Isometriks\Bundle\SymEditBundle\Event\PageEvent;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function showAction(PageInterface $_page, Request $request)
    {
        $response = $this->createResponse($_page->getUpdatedAt());

        $event = new PageEvent($_page, $request);
        $this->container->get('event_dispatcher')->dispatch(Events::PAGE_VIEW, $event);

        if ($response->isNotModified($request)) {
            return $response;
        }

        if (($template = $_page->getTemplate()) === null) {
            throw new \Exception('Page does not have a template, cannot render');
        }

        return $this->render(sprintf('@SymEdit/Page/%s', $template), array(), $response);
    }
}
