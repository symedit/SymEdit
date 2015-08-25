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

use Sylius\Bundle\SettingsBundle\Manager\SettingsManagerInterface;
use SymEdit\Bundle\CoreBundle\Model\BreadcrumbsInterface;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\CoreBundle\Util\SymEditMailerInterface;
use SymEdit\Bundle\SeoBundle\Model\SeoInterface;
use SymEdit\Bundle\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Gets Settings.
     *
     * @return SettingsManagerInterface Settings
     */
    public function getSettings()
    {
        return $this->get('sylius.settings.manager');
    }

    /**
     * Gets Mailer.
     *
     * @return SymEditMailerInterface
     */
    public function getMailer()
    {
        return $this->get('symedit.mailer');
    }

    /**
     * Gets the breadcrumbs.
     *
     * @return BreadcrumbsInterface $breadcrumbs
     */
    public function getBreadcrumbs()
    {
        return $this->get('symedit.breadcrumbs');
    }

    /**
     * Gets the user manager.
     *
     * @return UserManagerInterface $userManager
     */
    public function getUserManager()
    {
        return $this->get('fos_user.user_manager');
    }

    /**
     * Adds a breadcrumb to the current request.
     *
     * @param string $title
     * @param string $path
     * @param array  $params
     */
    public function addBreadcrumb($title, $path = null, array $params = array())
    {
        /*
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
     * Gets the current page if there is one, or returns null.
     *
     * @return PageInterface|null
     */
    public function getCurrentPage()
    {
        $request = $this->getRequest();

        if ($request->attributes->has('_page')) {
            return $request->attributes->get('_page');
        }

        return;
    }

    /**
     * Gets the current SEO.
     *
     * @return SeoInterface
     */
    public function getSeo()
    {
        return $this->get('symedit_seo.seo');
    }
}
