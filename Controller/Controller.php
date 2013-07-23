<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    /**
     * Creates a new response and only sets it to public if caching is allowed.
     *
     * @return \Symfony\Component\HttpFoundation\Response Response Object
     */
    public function createResponse(\DateTime $modified = null)
    {
        $response = new Response();

        if($this->isCacheable()){

            if($modified === null){
                $modified = new \DateTime();
            }

            $response->setPublic();
            $response->setLastModified($modified);
        }

        return $response;
    }

    /**
     * Determines whether the response should be cached or not, checks the
     * settings for the cache setting, and whether or not live editing is allowed.
     *
     * @return boolean
     */
    public function isCacheable()
    {
        $settings = $this->getSettings();
        $context = $this->get('security.context');

        $cacheable = $settings->has('advanced.caching') && $settings->get('advanced.caching') === 'cache';
        $editable = $context->isGranted('ROLE_ADMIN_EDITABLE');

        return $cacheable && !$editable;
    }

    /**
     * Gets the host bundle
     *
     * @return string The host bundle
     */
    public function getHostBundle()
    {
        return $this->container->getParameter('isometriks_symedit.host_bundle');
    }

    /**
     * Gets the host namespace
     *
     * @return string The host namespace
     */
    public function getHostNamespace()
    {
        return $this->container->getParameter('isometriks_symedit.host_namespace');
    }

    /**
     * Prepends the host bundle to the template in format HostBundle:Controller:template
     *
     * @deprecated since version 2.3
     * @param string $controller
     * @param string $template
     * @return string Template in format HostBundle:Controller:template
     */
    public function getHostTemplate($controller, $template)
    {
        trigger_error('getHostTemplate deprecated. Used @SymEdit/... to reference templates.', E_USER_DEPRECATED);

        return $this->getHostBundle().':'.$controller.':'.$template;
    }

    /**
     * Gets Settings
     *
     * @return \Isometriks\Bundle\SettingsBundle\Model\Settings Settings
     */
    public function getSettings()
    {
        return $this->get('isometriks_settings.settings');
    }

    /**
     * Gets the breadcrumbs
     *
     * @return \Isometriks\Bundle\SymEditBundle\Model\BreadcrumbsInterface $breadcrumbs
     */
    public function getBreadcrumbs()
    {
        return $this->get('isometriks_symedit.breadcrumbs');
    }

    /**
     * Gets the current page if there is one, or returns null
     *
     * @return \Isometriks\Bundle\SymEditBundle\Model\PageInterface|null
     */
    public function getCurrentPage()
    {
        $request = $this->getRequest();

        if($request->attributes->has('_page')){
            return $request->attributes->get('_page');
        }

        return null;
    }

    protected function addFlash($type, $message)
    {
        $this->get('session')->getFlashBag()->add($type, $message);
    }
}
