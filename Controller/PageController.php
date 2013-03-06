<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SymEditBundle\Entity\Page;

class PageController extends Controller
{
    public function showAction(Page $entity, Request $request)
    {
        $response = new Response();
        $settings = $this->get('isometriks_settings.settings');
        $editable = $this->get('security.context')->isGranted('ROLE_ADMIN_EDITABLE');

        /**
         * If cache option exists, and it is set to cache, try to serve it from cache. 
         * Also, don't serve cached anything if editable is on. 
         */
        if ($settings->has('advanced.caching') && $settings->get('advanced.caching') === 'cache' && !$editable) {
            $response->setLastModified($entity->getUpdatedAt());

            if ($response->isNotModified($request)) {
                $response->setPublic();
                return $response;
            }
        }

        // Set it active and traverse
        $entity->setActive(true, true);

        // Insert Page variable into the Request headers
        $request->attributes->add(array(
            '_page' => $entity,
        ));

        $host_bundle = $this->container->getParameter('isometriks_sym_edit.host_bundle');
        $template = sprintf('%s:Page:%s', $host_bundle, $entity->getTemplate());

        return $this->render($template, array(
            'Page' => $entity,
            'SEO' => $entity->getSeo(),
        ), $response);
    }
}
