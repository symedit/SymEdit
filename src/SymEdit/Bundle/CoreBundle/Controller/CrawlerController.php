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

class CrawlerController extends Controller
{
    public function robotsAction()
    {
        $settings = $this->get('symedit_settings.settings');

        if ($settings->has('webmaster.robots')) {
            $allow = $settings->get('webmaster.robots') === 'allow';
        } else {
            $env = $this->container->getParameter('kernel.environment');
            $allow = $env === 'prod';
        }

        return $this->render('@SymEdit/Crawler/robots.txt.twig', array(
            'Allow' => $allow,
        ));
    }
}
