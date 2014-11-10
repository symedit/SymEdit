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

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use SymEdit\Bundle\CoreBundle\Model\Seo;
use SymEdit\Bundle\CoreBundle\Model\SeoInterface;

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

        if ($this->isCacheable()) {

            if ($modified !== null) {
                $response->setLastModified($modified);
            }

            $response->setPublic();
            $response->setSharedMaxAge(60);
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

        $cacheable = $settings->has('advanced.caching') && $settings->get('advanced.caching') === 'cache';
        $admin = $this->get('security.context')->isGranted('ROLE_ADMIN');

        return $cacheable && !$admin;
    }

    /**
     * Gets Settings
     *
     * @return \SymEdit\Bundle\SettingsBundle\Model\Settings Settings
     */
    public function getSettings()
    {
        return $this->get('symedit_settings.settings');
    }

    /**
     * Gets Mailer
     *
     * @return \SymEdit\Bundle\CoreBundle\Util\SymEditMailerInterface
     */
    public function getMailer()
    {
        return $this->get('symedit.mailer');
    }

    /**
     * Gets the breadcrumbs
     *
     * @return \SymEdit\Bundle\CoreBundle\Model\BreadcrumbsInterface $breadcrumbs
     */
    public function getBreadcrumbs()
    {
        return $this->get('symedit.breadcrumbs');
    }

    /**
     * Gets the user manager
     *
     * @return \SymEdit\Bundle\UserBundle\Model\UserManagerInterface $userManager
     */
    public function getUserManager()
    {
        return $this->get('fos_user.user_manager');
    }

    /**
     * Adds a breadcrumb to the current request
     *
     * @param string $title
     * @param string $path
     * @param array  $params
     */
    public function addBreadcrumb($title, $path = null, array $params = array())
    {
        /**
         * If no path supplied, use the matched one
         */
        if ($path === null || $params === null) {
            $request = $this->getRequest();
            $path = $request->get('_route');
            $params = $request->get('_route_params', array());
        }

        $this->getBreadcrumbs()->push($title, $path, $params);
    }

    /**
     * Gets the current page if there is one, or returns null
     *
     * @return \SymEdit\Bundle\CoreBundle\Model\PageInterface|null
     */
    public function getCurrentPage()
    {
        $request = $this->getRequest();

        if ($request->attributes->has('_page')) {
            return $request->attributes->get('_page');
        }

        return null;
    }

    /**
     * Gets the current SEO
     *
     * @return \SymEdit\Bundle\SeoBundle\Model\SeoInterface
     */
    public function getSeo()
    {
        return $this->get('symedit_seo.seo');
    }

    protected function addFlash($type, $message)
    {
        $this->get('session')->getFlashBag()->add($type, $message);
    }
}
